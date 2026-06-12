## ADDED Requirements

### Requirement: Recent receipts table
The dashboard SHALL display a list of the 5 most recent receipts belonging to the authenticated user, showing title, status badge, depense count, and creation date.

#### Scenario: Recent receipts displayed
- **WHEN** the authenticated user has receipts
- **THEN** the dashboard shows the 5 most recent receipts by `created_at` descending

#### Scenario: Clicking a receipt navigates to show page
- **WHEN** the user clicks on a receipt title in the recent list
- **THEN** they are navigated to `recus.show` for that receipt
