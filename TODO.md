# TODO: Fix Route [company.applications.this_month] Not Defined

## Tasks
- [x] Update route name in routes/web.php from 'pelamar.month' to 'applications.this_month'
- [x] Update view references in resources/views/company/dashboard/index.blade.php from 'company.pelamar.month' to 'company.applications.this_month'
- [x] Update view references in resources/views/company/pelamar/index.blade.php from 'company.pelamar.month' to 'company.applications.this_month'
- [x] Clear route cache (php artisan route:clear)
- [x] Test the route to ensure it works - Route now properly registered as company.applications.this_month

# TODO: Fix Route [lamarans.update] Not Defined

## Tasks
- [x] Add PUT route for applications update in routes/web.php with name 'lamarans.update'
- [x] Add update method in ApplicationController to handle CV upload updates
- [x] Fix view fields to use correct model relationships (user->name, jobPost->title, cv_path)
- [x] Make nama_pelamar and lowongan readonly in edit form
- [x] Update cancel link to use correct route 'company.pelamar.all'
- [x] Update form action to use 'company.lamarans.update' to match the prefixed route name
- [x] Clear route cache
- [x] Test the route to ensure no more "Route [lamarans.update] not defined" error
