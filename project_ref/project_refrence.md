# Project Reference & Instructions

## User Preferences & Rules
1. **Design First**: Always transform prompts into high-quality, premium designs. No basic MVP styling.
2. **Stitch Integration**: Use `/core/stitch/` as the visual and code source of truth.
3. **Real Data**: Avoid dummy text/placeholders. Use real functionality.
4. **CSS & CDN**: Ensure all external resources (fonts, icons, Tailwind) are properly included.
5. **Documentation**: Maintain `task.md`, `walkthrough.md`, and `implementation_plan.md` in `<appDataDir>/brain/<conversation-id>`.
6. **Project Timeline**: Track progress in `task.md`.

## Project Timeline & To-Do List

### Phase 1: Core Student Experience (High Priority)
- [x] Course Catalog Page (Stitch: `church_lms_dashboard_3`)
- [x] Course Single/Landing Page (Stitch: `church_lms_dashboard_4` - adapted)
- [x] Instructor Profile Page (Stitch: `church_lms_dashboard_4`)
- [ ] Session Booked Confirmation (Stitch: `church_lms_dashboard_12`)
- [ ] Student Profile Page
- [ ] Student Settings Page

### Phase 2: Interactive Learning
- [ ] Quiz System
- [ ] Score/Results Display
- [ ] Course Completion Certificate

### Phase 3: Instructor Panel
- [ ] Course Creation Flow
- [ ] Student List
- [ ] Instructor Settings

### Phase 4: Book & Library (Completed)
- [x] Paywall System logic
- [x] Book Creation Flow
- [x] Phase 5: Paid Book Checkout Flow (Store Integration, Success View)
- [x] Phase 6: Stability & Theme (Redirect fixes, Default Dark Mode)
- [x] Phase 2: Multimedia Redesign & Reader Enhancements
    - [x] Multimedia Library UI (Strict Template Parity)
    - [x] Advanced Reader (Font Scaling & Voice Assistant)
    - [x] Chapter Auto-Initialization Logic
    - [x] Cleaned up Storage URLs via model accessors
- [x] Fullscreen Reader Layout (`layouts/reader.blade.php`)
- [x] Phase 3: Collection Management & Reader Progress tracking

### Phase 5: Meeting System
- [ ] Waiting Room UI

### Phase 6: Community
- [ ] Community Hub
- [ ] Groups & Rooms

## Key Directories
- `core/stitch/`: Design references
- `core/resources/views/`: Blade templates
- `core/app/Http/Controllers/`: Backend logic
- `core/routes/web.php`: Routing

*This file acts as a central reference for the project state and user preferences.*
