# Implementation Plan: Fix Meeting Room UI Icons & Layout

The meeting room UI is currently "broken" because the Material Symbols font is not loading correctly. This causes icons to render as raw text, which then overflows the fixed-size control buttons and mashes them together.

## Proposed Changes

### [Frontend] Meeting Room View
- **File:** [room.blade.php](file:///c:/xampp/htdocs/dbim/core/resources/views/frontend/meeting/room.blade.php)
- **Robust Font Loading:** Used the most compatible Google Fonts link for Material Symbols Outlined.
- **Tailwind Integration:** Added Tailwind CDN to match the design system exactly.
- **Strict CSS:** Implemented CSS rules to force ligatures (`font-feature-settings: 'liga'`) and ensure the font family is applied with `!important`.
- **Layout Constraint:** Added `max-height` and `max-width` to `#mainStage` to prevent it from covering the screen and pushing controls off-screen.
- **Mobile Viewport Fix:**
    - Adjusted `#videoArea` and `#galleryStrip` for better vertical stacking.
    - Added fixed dimensions for `#mainStage` on mobile to ensure layout stability.
- **Notification System:**
    - **Fixed Toast:** Reimplemented the "Link Copied" toast with fixed positioning and transition effects to ensure it disappears correctly.
    - **Unread Badge:** Added a real-time notification badge to the chat button that tracks unread messages when the sidebar is closed or on a different tab.

## Verification Plan

### Manual Verification
1.  Open the meeting room at `localhost/dbim/meeting/{code}`.
2.  Verify icons are symbols.
3.  Resize the browser to mobile width and verify the layout (video, gallery, controls).
4.  Confirm the main video doesn't force the footer off-screen.
