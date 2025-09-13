# TODO: Fix Dummy Data Duplication

## Tasks
- [x] Update UserSeeder to generate multiple unique users per role with unique emails, names, phones, etc.
- [x] Update CompanySeeder to create unique companies per company user with unique names, phones, addresses.
- [x] Update JobPostSeeder to create multiple unique job posts with unique titles and companies.
- [x] Ensure ApplicationSeeder maintains unique user-job post combinations.
- [x] Add validation for unique email in user creation (e.g., in RegisterRequest or ProfileRequest).
- [x] Test that edit/delete operations affect only one record.
- [x] Run migrations and seeders to verify uniqueness.
