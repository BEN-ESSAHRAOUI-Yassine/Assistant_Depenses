## Context

The dashboard currently shows two quick-action buttons and nothing else. Users must navigate to receipts to see any data. No aggregate insights (totals, trends, category breakdown) are available anywhere in the app.

## Goals / Non-Goals

**Goals:**
- Replace placeholder dashboard with stats cards, charts, and recent receipts
- All queries scoped to authenticated user only
- Zero N+1 queries — use aggregate SQL
- Chart.js for interactive charts (doughnut + line)
- Responsive layout matching existing app design (Tailwind, same component library)

**Non-Goals:**
- Real-time auto-refresh or WebSockets
- Date range filtering on dashboard
- Export to CSV/PDF
- Multi-user admin dashboard

## Decisions

1. **Chart.js over pure CSS charts** — Chart.js provides proper legends, tooltips, responsive sizing, and accessibility. Alternative considered: CSS bar charts (no interactivity, no tooltips).

2. **Chart.js via npm + app.js import** — Bundles into Vite build, no CDN dependency. Alternative: CDN script tag (simpler but creates external dependency).

3. **Single DashboardController** — Keeps all dashboard queries in one place. The controller injects data via `compact()` to the view. Alternative: separate service class (over-engineered for 6 aggregate queries).

4. **Category total via SQL SUM** — `Depense::selectRaw('categorie, SUM(quantite * prix_unitaire) as total')->whereHas(...)->groupBy('categorie')->pluck('total', 'categorie')` — single query, no N+1.

5. **Monthly trend via DATE_FORMAT** — Groups receipts by `YEAR-MONTH` for last 6 months with `COUNT(*)` and `SUM(estimated_total)`. Alternative: PHP grouping (more memory, slower for large datasets).

6. **Data passed as JSON for Chart.js** — Controller prepares labeled arrays (`['labels' => [...], 'data' => [...]]`), view passes to Alpine.js `x-init` that instantiates charts.

## Risks / Trade-offs

- [Empty state] New users have no receipts → Mitigation: show helpful empty-state messaging with "Nouveau reçu" CTA
- [Chart.js bundle size] ~70KB minified → Mitigation: treeshake unused chart types via register
- [O/R] Debugbar reveals aggregate queries → Accepted: 5-6 queries is acceptable for a dashboard page load
