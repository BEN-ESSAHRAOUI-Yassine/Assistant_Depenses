## Why

The app has no overview page — users land on a blank dashboard with just two links. They must navigate to receipts to see any data. A dashboard with stats, charts, and recent activity gives instant visibility on spending patterns and extraction status.

## What Changes

- Replace the placeholder `/dashboard` route with `DashboardController@index`
- Build a full dashboard view with stats cards, expense category chart, monthly trend chart, and recent receipts table
- Add Chart.js for interactive visualizations
- Add a "Dépenses" link to the navigation sidebar

## Capabilities

### New Capabilities
- `dashboard-overview`: Stats cards (total receipts, processed/pending/failed counts, total amount) with scoped user queries
- `expense-charts`: Category breakdown (doughnut) and monthly trend (line) using Chart.js, sourced from aggregate queries
- `recent-activity`: Latest 5 receipts table with status, count, and date

### Modified Capabilities
*(None)*

## Impact

- `app/Http/Controllers/DashboardController.php` — new controller
- `resources/views/dashboard.blade.php` — fully rewritten
- `routes/web.php` — route 12-14 changes to controller call
- `resources/views/layouts/navigation.blade.php` — add Dépenses nav link
- `package.json` — add `chart.js` dependency
- `tests/Feature/DashboardControllerTest.php` — new test

## User Stories

- As a shop owner, I want to see how many receipts I've processed at a glance, so I know my usage volume.
- As a shop owner, I want to see my expenses broken down by category, so I know where most of my money goes.
- As a shop owner, I want to see my monthly spending trend, so I can spot changes over time.
- As a shop owner, I want quick access to recent receipts and actions from a single page.

## Non-goals

- Real-time auto-refresh or WebSockets
- Date range picker or advanced filtering on dashboard
- Export dashboard data to CSV/PDF
- Role-based dashboard variants
