## ADDED Requirements

### Requirement: User can list expenses from their receipts
The system SHALL display all expenses from the authenticated user's receipts.

#### Scenario: Viewing expense list
- **WHEN** an authenticated user visits the expenses index page
- **THEN** the system shows all expenses from their receipts, with the receipt title, ordered by most recent first

#### Scenario: Data isolation
- **WHEN** visiting the expense list
- **THEN** the user only sees expenses from receipts they own

### Requirement: User can filter expenses by category
The system SHALL allow filtering expenses by category.

#### Scenario: Filtering by category
- **WHEN** an authenticated user selects a category filter
- **THEN** the system only shows expenses matching that category

### Requirement: User can search expenses by label
The system SHALL allow searching expenses by their libelle field.

#### Scenario: Searching by keyword
- **WHEN** an authenticated user types a search term
- **THEN** the system only shows expenses whose libelle contains the term

### Requirement: User can sort expenses
The system SHALL allow sorting expenses by libelle, prix_unitaire, quantite, or categorie.

#### Scenario: Sorting by column
- **WHEN** an authenticated user clicks a sortable column header
- **THEN** the system reorders expenses by that column in ascending or descending order

### Requirement: Expense list is paginated
The system SHALL paginate the expense list.

#### Scenario: Pagination
- **WHEN** there are more than 15 expenses
- **THEN** the system shows a paginated list with navigation controls
