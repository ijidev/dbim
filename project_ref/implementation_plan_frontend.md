# Implementation Plan - Frontend UI and Data Fixes

## Goal Description
Fix the frontend pages (Home, Calendar, Livestream) where icons are displaying as names instead of icons. Replace dummy text and placeholder data with actual dynamic content from the database.

## Proposed Changes

### Frontend Layout and UI
#### [MODIFY] [app.blade.php](file:///c:/xampp/htdocs/dbim/core/resources/views/layouts/app.blade.php)
- Fix the Google Fonts CDN link to include all variable axes for Material Symbols.
- Consolidate and correct the `.material-symbols-outlined` CSS class to ensure the proper `font-family` is applied globally.
- Ensure the `-webkit-font-smoothing` is applied for sharper icons.

### Home Page
#### [MODIFY] [index.blade.php](file:///c:/xampp/htdocs/dbim/core/resources/views/frontend/index.blade.php)
- Remove redundant inline Material Symbols CSS.
- Ensure the "Joined the Discipleship Academy" count reflects the real student count.

### Livestream Page
#### [MODIFY] [live.blade.php](file:///c:/xampp/htdocs/dbim/core/resources/views/frontend/live.blade.php)
- Replace the hardcoded "Sunday Service: Worship & Word" title with the event title from the database (if live) or the latest sermon.
- Replace the hardcoded "Next Session" promo (Academy: Intro to Theology) with the actual next upcoming event from the database.
- Clean up hardcoded chat messages to provide a cleaner "Start the conversation" state.
- Remove redundant inline Material Symbols CSS.

### Calendar Page
#### [MODIFY] [calendar.blade.php](file:///c:/xampp/htdocs/dbim/core/resources/views/frontend/calendar.blade.php)
- Global layout fixes will handle the icons.
- Ensure the list view link is correctly pointing to the events list.

### Controller Logic
#### [MODIFY] [FrontController.php](file:///c:/xampp/htdocs/dbim/core/app/Http/Controllers/FrontController.php)
- Add logic to fetch the `next_event` for the livestream page sidebar.

## Verification Plan

### Manual Verification
- Navigate to `http://localhost/dbim/` and verify icons in the feature grid.
- Navigate to `http://localhost/dbim/live` and verify:
    - Sidebar shows the actual next event from the database.
    - Stream title matches the current live setting or latest sermon.
- Navigate to `http://localhost/dbim/calendar` and verify calendar icons.
