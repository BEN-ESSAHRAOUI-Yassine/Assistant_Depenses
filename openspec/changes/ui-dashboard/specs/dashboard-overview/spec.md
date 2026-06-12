## ADDED Requirements

### Requirement: Stats cards display aggregate overview
The dashboard SHALL display stats cards showing: total receipts count, processed receipts (traité), pending receipts (en attente), failed receipts (échoué), and total estimated amount. All counts SHALL be scoped to the authenticated user.

#### Scenario: Authenticated user sees stats
- **WHEN** an authenticated user visits `/dashboard`
- **THEN** the page displays 5 stats cards with counts

#### Scenario: Stats reflect user's own data only
- **WHEN** two users have receipts
- **THEN** each user only sees their own receipt counts on their dashboard

#### Scenario: Zero state shows zeros
- **WHEN** a new user with no receipts visits `/dashboard`
- **THEN** all stat cards display 0 or appropriate empty value

#### Scenario: Unauthenticated user is redirected
- **WHEN** a guest visits `/dashboard`
- **THEN** they are redirected to the login page

### Requirement: Dashboard route uses controller
The `/dashboard` route SHALL be served by `DashboardController@index` with the `auth` and `verified` middleware.

#### Scenario: Route returns controller response
- **WHEN** a request hits `GET /dashboard`
- **THEN** the `DashboardController@index` method handles it
