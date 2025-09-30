# TODO: Remove Admin Registration Feature

## Tasks
- [x] Modify RegisteredUserController to remove 'admin' from validRoles in create() and store() methods
- [x] Remove admin button from resources/views/auth/register_choice.blade.php
- [x] Delete resources/views/auth/register_admin.blade.php
- [x] Delete public/css/register-admin.css
- [x] Delete public/js/register-admin.js
- [ ] Test that /register/admin returns 404 or 404 page
