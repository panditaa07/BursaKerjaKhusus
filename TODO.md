# TODO: Fix Company Login Redirection Issue

## Problem
Company users cannot log in properly - redirected to home instead of dashboard due to missing company_id linking users to Company records.

## Steps
- [x] Edit database/seeders/UserSeeder.php to create Company records for company users and link via company_id
- [x] Edit database/seeders/DatabaseSeeder.php to remove CompanySeeder call (companies now created in UserSeeder)
- [x] Run `php artisan db:seed` to apply changes
- [ ] Test login with company@bkk.com / password to verify redirection to /company/dashboard

## Files to Edit
- database/seeders/UserSeeder.php
- database/seeders/DatabaseSeeder.php
