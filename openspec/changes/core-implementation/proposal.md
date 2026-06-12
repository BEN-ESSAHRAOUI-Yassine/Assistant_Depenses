## Why

The app needs to be fully functional and production-ready. The existing code has two blockers (missing import, missing expenses view), several code quality issues, and no test coverage. Without these fixes, the app crashes on key routes and cannot pass evaluation.

## What Changes

- Fix missing `use` import for `DepenseController` in web.php
- Create `depenses/index.blade.php` with search, category filter, paginate, and sort
- Fix cast key mismatch (`total_estime` → `estimated_total`) in `Recu` model
- Fix `RecuPolicy` — `viewAny()` and `create()` return `true`
- Fix migration `down()` — drops `recus` (not `recu`)
- Remove dead commented-out code from `RecuController::store()`
- Add nullable migration for `estimated_total`
- Add search and sort capabilities to `DepenseController`
- Create `RecuFactory` and `DepenseFactory`
- Write Pest tests for Recu CRUD, Depense listing, and Job extraction

## Capabilities

### New Capabilities

- `recu-crud`: Receipt creation, listing, viewing, and deletion with ownership enforcement and async AI extraction
- `depense-listing`: Expense listing with category filter, search, sort, and pagination, scoped to the authenticated user's receipts
- `ai-extraction`: Asynchronous AI-powered expense extraction from receipt text via queue jobs with structured output

### Modified Capabilities

None — first spec pass.

## Impact

- `routes/web.php`: one `use` statement added
- New view `resources/views/depenses/index.blade.php`
- Minor model/policy/migration corrections
- 2 new factories, 3 new test files
- New migration for nullable `estimated_total`
