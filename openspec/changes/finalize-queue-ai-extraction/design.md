## Context

`ExtraireDepensesDuRecu` currently runs once with no retry. A transient Groq failure (e.g., 5xx, timeout) immediately sets the receipt to `echoue`. The user must manually click "Relancer l'extraction". There is no response structure validation — if the AI returns `{"articles": null}` or omits keys, PHP throws an uncaught error. No error message is persisted, so the user cannot diagnose failures. Duplicate dispatches are possible if the user clicks retry rapidly.

## Goals / Non-Goals

**Goals:**
- Automatic retry (3 attempts, exponential backoff) for transient failures
- Response structure validation before processing articles
- Human-readable error message persisted on the `Recu` model
- `ShouldBeUnique` to prevent duplicate job dispatches for the same receipt
- Mail notification on permanent failure sent to the receipt owner
- Error message displayed in the receipt show view and cleared on successful retry

**Non-Goals:**
- Real-time status updates (no polling, no WebSockets)
- Admin dashboard for queue monitoring
- Slack or other notification channels
- Changing the AI provider or model

## Decisions

1. **Retry strategy: `$tries = 3` + `$backoff = [10, 30]`**
   - First retry after 10 seconds, second after 30 seconds (exponential from base)
   - Alternative considered: constant backoff — rejected because transient API issues typically resolve within seconds
   - `$maxExceptions = 1` — only retry on connection/API errors, not business logic failures

2. **Unique guard: `ShouldBeUnique` + `uniqueId()` returning `$this->recu->id`**
   - Prevents duplicate jobs for the same receipt from flooding the queue
   - `uniqueFor(60)` — release lock after 60 seconds so legitimate retries can proceed
   - Alternative considered: `WithoutOverlapping` middleware — rejected because it's for the same job running concurrently, not preventing duplicates in the queue

3. **Response validation: explicit type guards before `foreach`**
   - Validate `$response['articles']` is an array before iterating
   - Wrap each article creation in a try/catch to skip malformed items
   - Validate `$response['total_estime']` is numeric before writing
   - Alternative considered: JSON Schema validation — overengineered for a known schema from our own agent

4. **Error message field: nullable `text` column `error_message` on `recus`**
   - Stores a human-readable, French message (e.g., "L'API Groq est temporairement indisponible. Réessai automatique...")
   - Cleared to `null` on success or when retry is triggered
   - Alternative considered: separate `extraction_logs` table — overkill for a single message per receipt

5. **Notification: `ExtractionEchouee` mail notification via `Queue::failing()`**
   - Registered in `AppServiceProvider::boot()` using `Queue::failing()`
   - Sends to `$recu->user->email` with receipt title and error message
   - Subject and text in French
   - Alternative considered: notification in `failed()` method on the Job — simpler but less decoupled

## Risks / Trade-offs

- [Retry flooding] `ShouldBeUnique` with 60s lock prevents rapid retries → Mitigation: lock is short enough that user can retry after waiting
- [Email bounces] Invalid user email → Mitigation: default Laravel mail fail-silent behavior; notification wraps in try/catch
- [Error message leak] Raw API error details exposed → Mitigation: only store sanitized, human-readable messages, never raw exception trace
- [Migration order] New column must not break existing code → Mitigation: nullable default, cast handles null gracefully
- [Test fidelity] `Queue::failing()` is harder to test in isolation → Mitigation: test the notification class separately, test the job's `failed()` method flow
