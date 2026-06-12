## ADDED Requirements

### Requirement: Error message persistence
The `recus` table SHALL have a nullable `error_message` text column. When extraction fails, the job SHALL store a human-readable French error message. The message SHALL be set to `null` on successful extraction or when retry is triggered.

#### Scenario: Error message stored on extraction failure
- **WHEN** the Groq API returns an error after all retries
- **THEN** the job SHALL store a French error message like "L'extraction a échoué après 3 tentatives. Cause : ..."
- **THEN** the receipt `error_message` field SHALL contain the message

#### Scenario: Error message cleared on successful extraction
- **WHEN** a previous extraction failed with `error_message = "..."` stored
- **WHEN** a retry succeeds
- **THEN** the job SHALL set `error_message` to `null`

#### Scenario: Error message cleared on retry
- **WHEN** a receipt has `statut = echoue` with an `error_message`
- **WHEN** the user clicks "Relancer l'extraction"
- **THEN** the controller SHALL set `error_message` to `null`
- **THEN** the controller SHALL set `statut` to `en_attente`

### Requirement: Error message display
The receipt show view SHALL display the error message when present. It SHALL be visually distinct (e.g., red/orange alert box) and placed below the receipt metadata but above the expenses table.

#### Scenario: Error visible on echoue receipt
- **WHEN** a receipt has `statut = echoue` with an `error_message`
- **WHEN** the user views the receipt show page
- **THEN** the error message SHALL be displayed in a styled alert box
- **THEN** the "Relancer l'extraction" button SHALL be visible

#### Scenario: No error shown on successful receipt
- **WHEN** a receipt has `statut = traite` with `error_message = null`
- **WHEN** the user views the receipt show page
- **THEN** no error message box SHALL be displayed
