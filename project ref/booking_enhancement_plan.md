# Implementation Plan: Booking & Meeting Enhancements

This plan outlines the steps to resolve hardcoded fees, implement a checkout process, create a "My Bookings" page, and add privacy controls to the meeting system.

## Proposed Changes

### 1. Database Layer: Meetings Table
We need to add metadata to meetings to handle privacy and pricing.

#### [NEW] [Meeting Enhancement Migration](file:///c:/xampp/htdocs/dbim/core/database/migrations/2026_02_10_064500_enhance_meetings_table.php)
- **visibility**: `enum('public', 'private')` (default 'public')
- **price**: `decimal(10, 2)` (default 0.00)
- **max_participants**: `integer` (default 1)
- **allowed_student_ids**: `json` (nullable)

### 2. Controller Layer: StudentController
#### [MODIFY] [StudentController.php](file:///c:/xampp/htdocs/dbim/core/app/Http/Controllers/StudentController.php)
- **bookMeeting**: Update to save `visibility`, `price`, and `allowed_student_ids`.
- **myBookings**: New method for `/student/bookings`.
- **checkout**: New method for `/student/checkout/{id}`.

### 3. Controller Layer: MeetingController
#### [MODIFY] [MeetingController.php](file:///c:/xampp/htdocs/dbim/core/app/Http/Controllers/MeetingController.php)
- **room**: Add access check logic. If private, check if `auth()->id() == host_id` or `auth()->id()` is in `allowed_student_ids`.

### 4. Frontend Layer: Views
#### [NEW] [my_bookings.blade.php](file:///c:/xampp/htdocs/dbim/core/resources/views/frontend/student/my_bookings.blade.php)
- Premium list view of all sessions the student has booked or is hosting.

#### [NEW] [checkout.blade.php](file:///c:/xampp/htdocs/dbim/core/resources/views/frontend/student/checkout.blade.php)
- Payment summary page with simulated "Pay Now" button.

#### [MODIFY] [book_session.blade.php](file:///c:/xampp/htdocs/dbim/core/resources/views/frontend/student/book_session.blade.php)
- Add "Privacy" selection in Step 2.
- Remove hardcoded prices from Step 3 summary.

---

## Centralized Project Tracker

### 2026-02-10 07:44
- Initialized `project ref` folder.
- Synchronized existing `task.md` and `walkthrough.md`.
- Proposed Booking Enhancement Plan.
