# TODO: Fix Faker Unique Value Error

## Completed Tasks
- [x] Identified the error source: Faker's unique() method exhausting its pool in seeders
- [x] Fixed UserSeeder.php: Removed unique() calls for names, company names, and NISN numbers
- [x] Fixed JobPostSeeder.php: Replaced unique()->randomElement() with shuffled array approach
- [x] Fixed CompanyApplicationSeeder.php: Removed unique() calls for emails in both main method and createDummyUsers()

## Changes Made
### UserSeeder.php
- Admin names: `$faker->name . " Admin {$i}"` instead of `$faker->unique()->name`
- Company names: `$faker->company . " {$i}"` instead of `$faker->unique()->company`
- User names: `$faker->name . " User {$i}"` instead of `$faker->unique()->name`
- NISN: `$faker->numerify('##########') . $i` instead of `$faker->unique()->numerify('##########')`

### JobPostSeeder.php
- Replaced `$faker->unique()->randomElement($jobTitles)` with shuffled array and sequential picking
- Added `$shuffledTitles = $jobTitles; shuffle($shuffledTitles);` and `$title = $shuffledTitles[$titleIndex % count($shuffledTitles)];`

### CompanyApplicationSeeder.php
- Email generation: `$faker->email . '.' . $applicationCount` instead of `$faker->unique()->email`
- Company emails: `$faker->companyEmail . '.' . $emailCounter++` instead of `$faker->unique()->companyEmail`

## Next Steps
- [ ] Test the database seeding to ensure no "Maximum retries" error occurs
- [ ] Run `php artisan db:seed` or `php artisan migrate:fresh --seed` to verify the fix
- [ ] If error persists, check for other seeders or increase Faker's retry limit (not recommended)

## Notes
- The changes maintain data uniqueness through database constraints and manual suffixes
- Emails remain unique due to database unique constraints
- Names and other fields are made unique through concatenation with counters
- Job titles are randomized but can repeat across companies (which is acceptable for testing)
