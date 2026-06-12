## ADDED Requirements

### Requirement: User can create a receipt
The system SHALL allow an authenticated user to create a receipt by pasting raw OCR text.

#### Scenario: Successful creation
- **WHEN** an authenticated user submits a valid title and texte_source
- **THEN** the system creates a Recu with status `en_attente` owned by that user AND dispatches `ExtraireDepensesDuRecu` to the queue

#### Scenario: Validation errors
- **WHEN** an authenticated user submits an empty title, or texte_source shorter than 10 characters
- **THEN** the system returns validation errors and does NOT create a receipt

#### Scenario: Unauthenticated user
- **WHEN** a guest tries to access the create form or submit a receipt
- **THEN** the system redirects to the login page

### Requirement: User can list their receipts
The system SHALL display all receipts belonging to the authenticated user.

#### Scenario: Viewing receipt list
- **WHEN** an authenticated user visits the receipts index page
- **THEN** the system shows only their receipts, ordered by most recent first, with depense count per receipt

#### Scenario: Data isolation
- **WHEN** user A has receipts and user B visits the index
- **THEN** user B sees none of user A's receipts

### Requirement: User can view a single receipt
The system SHALL display a receipt's source text and extracted expenses.

#### Scenario: Viewing own receipt
- **WHEN** an authenticated user visits a receipt they own
- **THEN** the system shows the receipt with its source text and depenses

#### Scenario: Viewing another user's receipt
- **WHEN** an authenticated user visits a receipt they do NOT own
- **THEN** the system returns a 403 Forbidden

### Requirement: User can delete a receipt
The system SHALL allow an authenticated user to delete their own receipt.

#### Scenario: Deleting own receipt
- **WHEN** an authenticated user deletes a receipt they own
- **THEN** the system deletes the receipt and its depenses, then redirects to the index

#### Scenario: Deleting another user's receipt
- **WHEN** an authenticated user tries to delete a receipt they do NOT own
- **THEN** the system returns a 403 Forbidden
