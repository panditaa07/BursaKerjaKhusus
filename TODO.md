# TODO: Fix Errors and Bugs in BursaKerjaKhusus

## 1. Fix registration error (role_id assignment) ✅
- Update RegisteredUserController.php to assign role_id instead of 'role'

## 2. Fix job creation validation ✅
- Add industry_id required validation in JobPostController.php store method
- Change salary validation to numeric min 0
- Increase location max length to 500

## 3. Optimize queries (N+1 problem) ✅
- Review controllers and add eager loading for company.user, applications, etc.

## 4. Add company logo edit feature ✅
- Update company profile edit view and controller for logo upload

## 5. Fix company pelamar baru button bug ✅
- Inspect and correct button functionality in company views

## 6. Fix search pelamar layout bug ✅
- Adjust CSS for search layout

## 7. Fix lihat semua pelamar button and status color ✅
- Update JS for button action and CSS for status colors

## 8. Resolve login timeout ✅
- Change session driver to 'file' in config/session.php

## 9. Fix JSON/HTML response issue ✅
- Identify and correct the endpoint to return JSON

## 10. Fix logout relation ✅
- Ensure logout route properly clears session

## 11. Prevent login bypass ✅
- Apply auth middleware to protected routes

## 12. Validate cover letter ✅
- Add regex validation in Application creation for text/numbers only

## 13. Remove back button in lamaran saya ✅
- Edit lamaran saya view to remove unnecessary back button

## Followup
- Run migrations if needed
- Test all fixes
- Monitor performance
