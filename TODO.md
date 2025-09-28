# TODO: Fix delete button in Lowongan Terbaru cards on company dashboard

## Information Gathered
- Delete button in dashboard cards submits to `company.jobs.destroy` route (correct, as 'company.lowongan.destroy' doesn't exist).
- Form uses POST + @method('DELETE'), but lacks 'd-inline' class, uses English confirm, and no 'from' param to stay on dashboard.
- Controller redirects to 'company.jobs.all' by default; needs 'dashboard' case for redirect back.
- Success message in English; update to Indonesian.

## Plan
1. Update dashboard view form: Add `class="d-inline"`, change confirm to Indonesian, add hidden `name="from" value="dashboard"`.
2. Update controller: Change success message to Indonesian, add 'dashboard' case in `getRedirectRoute()` to return 'company.dashboard.index'.

## Dependent Files to be edited
- `resources/views/company/dashboard/index.blade.php` (form updates).
- `app/Http/Controllers/JobPostController.php` (message and redirect logic).

## Followup steps
- Test deletion from dashboard: Confirm stays on page, shows success message, and recent jobs update.
