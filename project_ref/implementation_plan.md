# Implementation Plan - Admin UI Fixes and Data Dynamicness

## Goal Description
Fix the admin menu and dashboard where icons are displaying as names instead of icons. Replace placeholder text and dummy data with actual dynamic content from the database.

## Proposed Changes

### Admin Layout and UI
#### [MODIFY] [app.blade.php](file:///c:/xampp/htdocs/dbim/core/resources/views/admin/layouts/app.blade.php)
- Fix the Google Fonts CDN link to include all variable axes for Material Symbols.
- Consolidate and correct the `.material-symbols-outlined` CSS class to ensure the proper `font-family` is applied.
- Ensure the `nav-icon` class correctly displays icons in the sidebar.

### Dashboard Content
#### [MODIFY] [dashboard.blade.php](file:///c:/xampp/htdocs/dbim/core/resources/views/admin/dashboard.blade.php)
- Replace static dummy data like `+12% This Month` and `Session in 2h` with Eloquent queries.
- Add logic to calculate enrollment trends and identify the next scheduled event.
- Ensure all icons in the dashboard body use the corrected Material Symbols class.

### Documentation
#### [MODIFY] [merged_progress.md](file:///c:/xampp/htdocs/dbim/project_ref/merged_progress.md)
- Append this implementation plan and keep track of project history.

## Verification Plan

### Automated Tests
- N/A (UI focused)

### Manual Verification
- Use the browser tool to navigate to `http://localhost/dbim/admin/dashboard` and verify:
    - Sidebar icons render correctly.
    - Dashboard stat cards show actual database counts (even if 0, they should be dynamic).
    - Icons like `groups`, `menu_book`, etc. render visually instead of text.
- Check other admin pages (`/admin/events`, `/admin/courses`, `/admin/livestream`) to ensure global layout fixes apply.
