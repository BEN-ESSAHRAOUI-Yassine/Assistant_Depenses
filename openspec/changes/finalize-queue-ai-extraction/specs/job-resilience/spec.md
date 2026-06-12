## ADDED Requirements

### Requirement: Job retry on transient failure
The `ExtraireDepensesDuRecu` job SHALL automatically retry up to 3 times when the Groq API returns a transient error (5xx, timeout, connection error). Retries SHALL use exponential backoff starting at 10 seconds. The job SHALL NOT retry on business logic failures (e.g., invalid response structure).

#### Scenario: Transient API failure triggers retry
- **WHEN** the Groq API returns a 503 Service Unavailable on the first attempt
- **THEN** the job SHALL retry after 10 seconds

#### Scenario: All retries exhausted marks receipt as echoue
- **WHEN** all 3 attempts fail with transient errors
- **THEN** the receipt status SHALL be set to `echoue` and error message stored

#### Scenario: Client error does not trigger retry
- **WHEN** the Groq API returns a 4xx client error
- **THEN** the job SHALL NOT retry and immediately mark the receipt as `echoue`

### Requirement: Unique job for receipt
The `ExtraireDepensesDuRecu` job SHALL use `ShouldBeUnique` to prevent multiple pending jobs for the same receipt. The unique lock SHALL be released after 60 seconds after the job completes or fails.

#### Scenario: Duplicate dispatch is prevented
- **WHEN** a job for receipt with id=5 is already dispatched
- **WHEN** a second dispatch is attempted for the same receipt id=5
- **THEN** the second dispatch SHALL be silently ignored

#### Scenario: Retry after 60 seconds is allowed
- **WHEN** a previous job for receipt id=5 completed 70 seconds ago
- **THEN** a new dispatch for receipt id=5 SHALL be accepted

### Requirement: Response structure validation
The job SHALL validate the AI response structure before processing. If `articles` is not an array, or if required keys are missing, the job SHALL set the receipt status to `echoue` with a descriptive error message.

#### Scenario: Malformed articles handled gracefully
- **WHEN** the AI returns `{"articles": null, "total_estime": 100, "currency": "MAD"}`
- **THEN** the job SHALL set receipt status to `echoue`
- **THEN** the job SHALL store a descriptive error message

#### Scenario: Missing total_estime handled gracefully
- **WHEN** the AI returns a response without `total_estime`
- **THEN** the job SHALL handle the missing key without crashing
- **THEN** the receipt status SHALL be set to `traite` if articles were successfully extracted
- **THEN** `estimated_total` SHALL be set to null
