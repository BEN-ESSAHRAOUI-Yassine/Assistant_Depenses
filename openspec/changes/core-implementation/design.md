## Context

The app has working Recu CRUD and Job dispatch but two blocker bugs (missing DepenseController import, missing expenses view), code quality issues (wrong cast key, policy errors, dead code), and zero test coverage. The depenses listing view needs search, category filter, sort, and pagination.

## Goals / Non-Goals

**Goals:**
- Fix all blocker and high-priority code quality issues
- Implement a full depenses listing with search, filter, sort, pagination
- Add RecuFactory and DepenseFactory for testing
- Achieve test coverage for Recu CRUD, Depense listing, and Job extraction

**Non-Goals:**
- No new features beyond what already exists
- No UI redesign
- No API endpoints

## Decisions

- **Depense listing scoped via `whereHas('recu')`**: Expenses belong to Recu which belongs to User. Using `whereHas` is cleaner than a direct join because it respects the relationship boundary and keeps the query readable.
- **`->paginate()` over `->get()`**: Prevents unbounded memory growth. 15 per page is a reasonable default for expense listings.
- **Search on `libelle` only**: The expense model has a single text field (`libelle`). Searching on `categorie` would overlap with the category filter.
- **Sort via query params**: `sort=libelle&direction=asc` — simple, RESTful, no extra dependencies.
- **Category filter uses enum cases**: The view renders a dropdown from `CategorieDepense::cases()`, avoiding hardcoded lists.
- **RecuFactory with states**: Three states (`en_attente`, `traite`, `echoue`) to test each status path. The `traite` state also creates depenses via a relationship callback.
- **Job test uses `Queue::fake()` and `Ai::fake()`**: No real API calls. `Queue::fake()` asserts dispatch, `Ai::fake()` mocks the structured response.

## Risks / Trade-offs

- [Risk] Missing `estimated_total` migration needs a new migration file — existing data will get `->nullable()->change()` which requires `doctrine/dbal` or Laravel 11+ native support. Laravel 13 natively supports this.
- [Risk] Search with `LIKE` on `libelle` is simple but not indexed — acceptable for the expected data volume of a single-store owner.
