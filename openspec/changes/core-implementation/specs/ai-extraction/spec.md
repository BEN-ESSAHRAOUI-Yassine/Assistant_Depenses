## ADDED Requirements

### Requirement: AI extraction runs asynchronously
The system SHALL process receipt text through AI extraction in a background job.

#### Scenario: Job is dispatched on receipt creation
- **WHEN** a receipt is created
- **THEN** the `ExtraireDepensesDuRecu` job is dispatched to the queue with the receipt

#### Scenario: Receipt shows pending status immediately
- **WHEN** a receipt is created
- **THEN** its status is `en_attente` before the job executes

### Requirement: Successful extraction creates expenses
The system SHALL create Depense records from the AI response when extraction succeeds.

#### Scenario: Expenses are created from AI response
- **WHEN** the job receives a valid structured response with articles
- **THEN** each article becomes a Depense linked to the receipt

#### Scenario: Receipt status updates to traite
- **WHEN** extraction succeeds
- **THEN** the receipt status becomes `traite`, payload_brut stores the full AI response, estimated_total and currency are saved

#### Scenario: Empty articles array
- **WHEN** the AI returns an empty articles array (text is not a receipt)
- **THEN** no expenses are created and status becomes `traite`

### Requirement: Failed extraction is handled gracefully
The system SHALL handle AI extraction failures without crashing.

#### Scenario: API failure
- **WHEN** the AI API call throws an exception
- **THEN** the receipt status becomes `echoue` and the exception is reported
