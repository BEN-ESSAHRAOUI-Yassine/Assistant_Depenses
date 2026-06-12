## 1. Controller and Routing

- [x] 1.1 Create `app/Http/Controllers/DashboardController.php` with `index()` method returning stats, chart data, and recent receipts
- [x] 1.2 Update `routes/web.php` to use `DashboardController@index` for the `/dashboard` route (remove closure)

## 2. Chart.js Setup

- [x] 2.1 Run `npm install chart.js` and import/register it in `resources/js/app.js`

## 3. Dashboard View

- [x] 3.1 Rewrite `resources/views/dashboard.blade.php` with stats cards grid, doughnut chart, line chart, and recent receipts table
- [x] 3.2 Add empty-state handling for new users with no data

## 4. Navigation

- [x] 4.1 Add "Dépenses" navigation link to `resources/views/layouts/navigation.blade.php` linking to `route('depenses.index')`

## 5. Tests

- [x] 5.1 Write `tests/Feature/DashboardControllerTest.php`: auth protection, stats display, chart data structure, zero state
- [x] 5.2 Run `php artisan test --compact` and confirm all tests pass

## 6. Final Verification

- [x] 6.1 Run `vendor/bin/pint --format agent` to format all PHP files
- [x] 6.2 Run `php artisan test --compact` and confirm all tests pass
