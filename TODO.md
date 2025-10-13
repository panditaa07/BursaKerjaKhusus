# TODO: Update Password Validation for Registration

## Tasks
- [x] Update `public/js/register-company.js` to remove additional password requirements (uppercase, lowercase, numbers) and keep only minimum 8 characters
- [x] Update password strength calculation in `register-company.js` to reflect new requirements
- [x] Update `public/js/register-user.js` to remove additional password requirements and keep only minimum 8 characters
- [ ] Test registration forms to ensure validation works correctly

## Files to Modify
- public/js/register-company.js
- public/js/register-user.js

## Notes
- Backend validation is already correct (only requires min:8 characters)
- Frontend JavaScript currently enforces additional requirements that need to be removed
- Password strength indicator should be updated to match new requirements
