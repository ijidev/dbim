# Implementation Plan - Event System Improvements

## Goal Description
1. Fix event cover image display issues caused by inconsistent pathing.
2. Improve recurrence logic to include an end date (preventing "infinite" looping).
3. Add support for "random dates" for an event (loopable).
4. Implement support for complex rules like "second and third week of every month".

## Proposed Changes

### Database
#### [MODIFY] [Event Model](file:///c:/xampp/htdocs/dbim/core/app/Models/Event.php)
- Add `extra_dates` to `$fillable`.

#### [NEW] [Migration](file:///c:/xampp/htdocs/dbim/core/database/migrations/2026_02_06_000001_add_extra_dates_to_events_table.php)
- Add `extra_dates` (text/json) to `events` table.

### Backend - Controller
#### [MODIFY] [EventController](file:///c:/xampp/htdocs/dbim/core/app/Http/Controllers/Admin/EventController.php)
- Update `store` and `update` to handle `extra_dates`.
- Fix image saving logic if needed (ensure consistency).

#### [MODIFY] [FrontController](file:///c:/xampp/htdocs/dbim/core/app/Http/Controllers/FrontController.php)
- Update `getEvents` logic:
    - Use `end_date` as the hard limit for recurrence.
    - If no `end_date`, default to 1 year as before.
    - Include occurrences from `extra_dates`.

### Frontend - Views
#### [MODIFY] [Single Event View](file:///c:/xampp/htdocs/dbim/core/resources/views/frontend/events/show.blade.php)
- Fix image path (remove `storage/` prefix to match `assets/images/events/`).

#### [MODIFY] [Home Page / Index](file:///c:/xampp/htdocs/dbim/core/resources/views/frontend/index.blade.php)
- Verify image paths.

### Admin - Views
#### [MODIFY] [Create/Edit Event Views](file:///c:/xampp/htdocs/dbim/core/resources/views/admin/events/create.blade.php)
- Add "Extra Dates" field (simple comma-separated or multi-date picker).
- Add "Loop Extra Dates" toggle (to repeat them monthly/yearly).

## Verification Plan
### Automated Tests
- N/A

### Manual Verification
1. Create an event with an image and verify it shows on both the index and show pages.
2. Create a recurring event with an `end_date` and verify it stops on the calendar.
3. Create an event with "extra dates" and verify they all appear on the calendar.
4. Verify "second and third week" logic if implemented via specific dates.
