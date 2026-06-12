## Why

The current AI extraction pipeline has no resilience or observability. A transient Groq outage permanently marks receipts as `echoue`, malformed AI responses crash the job silently, users see "Échoué" without understanding why, and no one is notified when jobs fail permanently. This makes the feature unreliable in production.

## What Changes

- Add retry/backoff to `ExtraireDepensesDuRecu` job (3 tries, exponential backoff)
- Validate AI response structure before processing (type guards, key existence checks)
- Store human-readable error messages on receipts when extraction fails
- Prevent duplicate job dispatches with `ShouldBeUnique`
- Send email notification to the receipt owner when a job fails permanently
- Display error messages in the receipt show view
- Update all existing Pest tests and add new ones covering these gaps

## Capabilities

### New Capabilities
- `job-resilience`: Retry/backoff configuration, `ShouldBeUnique`, and response validation guards on `ExtraireDepensesDuRecu`
- `error-visibility`: Error message persistence on `Recu`, display in show view, and clear on retry
- `failure-notification`: Mail notification to receipt owner on permanent job failure

### Modified Capabilities
*(None — existing specs remain unchanged)*

## Impact

- `app/Jobs/ExtraireDepensesDuRecu.php`: Add `$tries`, `$backoff`, `$maxExceptions`, `ShouldBeUnique`, response validation, error message storage
- `app/Models/Recu.php`: Add `error_message` to `$fillable`, cast as `string`
- `database/migrations/`: New migration adding `error_message` column to `recus`
- `app/Notifications/`: New `ExtractionEchouee` notification class
- `app/Providers/AppServiceProvider.php`: Register notification listener via `Queue::failing()`
- `resources/views/recus/show.blade.php`: Display error message if present
- `app/Http/Controllers/RecuController.php`: Clear error message on retry
- `tests/`: Update `ExtraireDepensesDuRecuTest`, add new test cases

## User Stories

- As a shop owner, I want extraction to retry automatically if Groq has a temporary hiccup, so I don't have to manually re-paste receipts.
- As a shop owner, if extraction fails permanently, I want to see why on the receipt page, so I know whether to fix the text or report a bug.
- As a shop owner, I don't want to accidentally flood the queue by clicking retry multiple times.
- As a shop owner, I want an email notification when extraction fails permanently, so I can follow up even if I'm not in the app.

## Non-goals

- Adding real-time polling or WebSockets for status updates
- Adding a dashboard or admin panel for queue monitoring
- Changing the AI provider or model
- Adding Slack/Discord/other notification channels
