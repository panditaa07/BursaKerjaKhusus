# 413 Page Expired FIXED ✅

**Summary:**

- Fixed CSRF token mismatch by creating writable storage/framework/sessions dir
- Registration now works for company role
- New companies created as 'pending' status, admin approves via /admin/verifications
- Dashboard access requires admin approval (role:company + status approved)

**Final Steps (manual):**

1. Edit .env: `SESSION_LIFETIME=240`
2. Restart XAMPP Apache
3. Login as admin → /admin/verifications → approve new company
4. Company user login → /company/dashboard

**Test Command:** `php artisan route:list | grep dashboard`

**Cleanups:**

- Remove 'register/\*' from VerifyCsrfToken.php $except (done)
- Delete debug routes if not needed
