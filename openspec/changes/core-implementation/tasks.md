## 1. Fix Blocker Bugs

- [x] 1.1 Add missing `use App\Http\Controllers\DepenseController` import in `routes/web.php`
- [x] 1.2 Fix cast key in `Recu.php` — `total_estime` → `estimated_total`

## 2. Code Quality Fixes

- [x] 2.1 Fix `RecuPolicy` — `viewAny()` and `create()` return `true`
- [x] 2.2 Fix migration `down()` — drop `recus` not `recu`
- [x] 2.3 Remove commented dead code in `RecuController::store()`
- [x] 2.4 Create migration to make `estimated_total` nullable

## 3. Depense Listing Feature

- [x] 3.1 Update `DepenseController::index()` with search, sort, paginate
- [x] 3.2 Create `resources/views/depenses/index.blade.php` with search, category filter, sortable headers, pagination

## 4. Factories

- [x] 4.1 Create `RecuFactory` with `en_attente`, `traite`, `echoue` states
- [x] 4.2 Create `DepenseFactory`

## 5. Tests

- [x] 5.1 Write `RecuTest` — index, create, store, show, destroy, ownership, validation
- [x] 5.2 Write `DepenseTest` — index, filter, search, sort, pagination, ownership
- [x] 5.3 Write `ExtraireDepensesDuRecuTest` — success path, failure path

## 6. Finalize

- [x] 6.1 Run Pint to fix code style
- [x] 6.2 Run all tests and confirm they pass
