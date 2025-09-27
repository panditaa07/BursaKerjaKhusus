# TODO: Fix Search on Lowongan Tidak Aktif Page

## Plan Overview
- Focus: Only admin role. Do not touch company or user logic.
- Issue: Search button ("Cari") not working; no results filtering on keyword input.
- Solution: Add proper form in view, handle search in controller with Eloquent query and pagination.

## Steps Completed
- [x] Update AdminDashboardController::lowonganTidakAktif to accept Request, add search logic for 'title' and 'company.name' using 'keyword' parameter, apply orderBy and paginate(10).
- [x] Update view lowongan-tidak-aktif.blade.php: Replace input with form (GET, action to route), input name="keyword", add "Cari" button, use $lowongan->total() for count.
- [x] Remove obsolete JavaScript for Enter key handling.

## Pending Steps
- [ ] Add pagination links to the view after the table to handle multiple pages.
- [ ] Update controller to append query parameters to paginator for preserving search across pages.
- [ ] Test: Verify search filters inactive jobs by title or company, pagination works, no errors.

## Follow-up
- Run `php artisan route:clear` if needed.
- Test in browser: Navigate to admin lowongan tidak aktif, search by keyword, check results and pagination.
