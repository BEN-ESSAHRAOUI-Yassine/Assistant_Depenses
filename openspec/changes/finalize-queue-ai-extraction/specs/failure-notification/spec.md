## ADDED Requirements

### Requirement: Permanent failure notification
When all retry attempts for `ExtraireDepensesDuRecu` are exhausted and the job fails permanently, the system SHALL send a mail notification to the receipt owner. The notification SHALL include the receipt title and the error message. The notification subject and body SHALL be in French.

#### Scenario: Owner receives email on permanent failure
- **WHEN** the job has exhausted all retry attempts for receipt with id=5
- **WHEN** the receipt has a valid owner with an email address
- **THEN** the system SHALL send a mail notification to the owner
- **THEN** the email SHALL contain the receipt title
- **THEN** the email SHALL contain a French message indicating the failure

#### Scenario: Non-existent user does not cause error
- **WHEN** the receipt owner has been deleted before the job completes
- **THEN** the system SHALL NOT throw an exception
- **THEN** the job failure SHALL be handled gracefully

### Requirement: Notification registration
The notification SHALL be registered globally using `Queue::failing()` in `AppServiceProvider::boot()`. It SHALL listen for failed jobs of the `ExtraireDepensesDuRecu` class.

#### Scenario: Notification registered on queue failing event
- **WHEN** a job of class `ExtraireDepensesDuRecu` fails permanently
- **THEN** the queue failing event SHALL trigger the notification
- **THEN** the `ExtractionEchouee` notification SHALL be sent to the receipt owner

### Requirement: Mail notification content
The `ExtractionEchouee` notification SHALL be a mail notification with:
- Subject: "Échec de l'extraction : {receipt title}"
- Body containing receipt title and error message
- Template using Laravel's default mail markdown
- Sent to the receipt owner's email address

#### Scenario: Notification content is correct
- **WHEN** the notification is sent for receipt titled "Facture 123" with error "API indisponible"
- **THEN** the email subject SHALL be "Échec de l'extraction : Facture 123"
- **THEN** the email body SHALL contain "Facture 123"
- **THEN** the email body SHALL contain "API indisponible"
