## ADDED Requirements

### Requirement: Category breakdown doughnut chart
The dashboard SHALL display a doughnut chart showing expenses grouped by category (`alimentaire`, `boissons`, `hygiene`, `entretien`, `autre`). The value for each category SHALL be the sum of `(quantite * prix_unitaire)` across all depenses belonging to the authenticated user's receipts.

#### Scenario: Chart shows correct category totals
- **WHEN** the authenticated user has expenses in multiple categories
- **THEN** the doughnut chart displays each category with proportional segment sizes

#### Scenario: Empty category chart
- **WHEN** the authenticated user has no expenses
- **THEN** the chart area shows a "Aucune donnée" empty state instead of a chart

### Requirement: Monthly trend line chart
The dashboard SHALL display a line chart showing the number of receipts per month and total estimated amount for the last 6 months.

#### Scenario: Trend shows last 6 months
- **WHEN** the authenticated user has receipts spanning multiple months
- **THEN** the line chart shows data points for each of the last 6 months

#### Scenario: Missing months show zero
- **WHEN** a month in the last 6 has no receipts
- **THEN** that month shows 0 receipts and 0 amount on the chart

### Requirement: Chart.js is the charting library
The system SHALL use Chart.js (installed via npm) for all charts. Charts SHALL be initialized via Alpine.js `x-init` on canvas elements.

#### Scenario: Chart renders without errors
- **WHEN** the dashboard page loads
- **THEN** canvas elements are populated with Chart.js charts
- **THEN** no JavaScript console errors occur
