# Company Role Display Fix Progress

## Plan Summary
Fix all Company role pages to match Admin role styling with consistent Bootstrap design, proper tables, forms, and details.

## Tasks to Complete

### 1. Company Jobs Index (`resources/views/company/jobs/index.blade.php`)
- [ ] Redesign table with proper Bootstrap styling like Admin
- [ ] Add proper numbering column
- [ ] Add action buttons (View, Edit, Delete)
- [ ] Add search functionality
- [ ] Add status badges
- [ ] Make responsive

### 2. Company Jobs Create (`resources/views/company/jobs/create.blade.php`)
- [ ] Redesign form layout to match Admin style
- [ ] Use card layout
- [ ] Add proper form validation styling
- [ ] Add back button using url()->previous()
- [ ] Improve field arrangement

### 3. Company Jobs Edit (`resources/views/company/jobs/edit.blade.php`)
- [ ] Same improvements as create page
- [ ] Pre-populate form fields properly

### 4. Company Jobs Show (Create new file: `resources/views/company/jobs/show.blade.php`)
- [ ] Create detailed job view matching Admin style
- [ ] Show all job information in organized sections
- [ ] Add applicants table
- [ ] Add back button and edit button

### 5. Company Applications Show (`resources/views/company/applications/show.blade.php`)
- [ ] Complete redesign to match Admin applications show style
- [ ] Add proper user information display
- [ ] Add application details
- [ ] Add file download links
- [ ] Add back button

## Progress Status
- [ ] Task 1: Company Jobs Index
- [ ] Task 2: Company Jobs Create
- [ ] Task 3: Company Jobs Edit
- [ ] Task 4: Company Jobs Show (NEW)
- [ ] Task 5: Company Applications Show

## Notes
- All changes should maintain existing functionality
- Use consistent styling with Admin role
- Ensure responsive design
- Add proper validation and error handling
