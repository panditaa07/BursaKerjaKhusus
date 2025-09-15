# Cleanup and Refactor Laravel Project - TODO List

## Step 1: Remove Unused Files and Components
- Identify and delete unused controllers, views, helpers, CSS/JS assets.
- Remove duplicate files or fix duplicates if used.

## Step 2: Fix Folder Structure
- Ensure Controllers are in app/Http/Controllers
- Ensure Models are in app/Models
- Ensure Views are in resources/views
- Move misplaced files to correct locations.

## Step 3: Clean Routes
- Remove unused routes from routes/web.php, routes/admin.php, routes/user.php, routes/console.php.
- Keep only routes currently used by the application.

## Step 4: Code Cleanup
- Remove unused functions, methods, and imports.
- Remove commented-out code and dead code.
- Fix code formatting to PSR-12 standards.
- Refactor Blade templates to remove duplicates and use @include or @component.

## Step 5: Database Cleanup
- Remove unused migrations, seeders, and factories.
- Ensure seeders generate unique data.
- Verify foreign key relationships are correct.
- Run migrations and seeders to confirm no errors.

## Step 6: Dependency and Asset Cleanup
- Remove unused dependencies from composer.json and package.json.
- Run composer update.
- Run npm install and npm run build.
- Remove unused CSS/JS assets.

## Step 7: Testing and Validation
- Test all pages (Admin, Company, User) for errors.
- Test all CRUD features.
- Test file upload/download (CV, logo, application letter).
- Verify "Loker Tersedia" shows correct job listing count.

## Step 8: Finalize
- Ensure project is clean, structured, and consistent.
- No dead code or unused files remain.
- All features work as expected.

---

I will proceed step-by-step following this TODO list and update progress accordingly.
