# DBIM Project Master Reference

**Last Updated:** 2026-01-21
**Status:** In Progress
**Project Location:** `c:/xampp/htdocs/dbim`

## 1. Project Overview
DBIM is a **mobile-first, responsive** Church Website built to serve as a comprehensive digital hub. It integrates live streaming, event management, learning (LMS), e-commerce, and digital publishing into a unified platform.

### Core Philosophy
- **Mobile-First Design:** Optimized for mobile devices first, scaling up to desktops.
- **Responsiveness:** Seamless experience across all devices and platforms.
- **Modern & Dynamic:** High-end aesthetics, smooth transitions, and premium feel.

## 2. Technical Foundation
Based on initial analysis:
- **Framework:** Laravel 11.9 (PHP 8.2+)
- **Database:** MySQL
- **Frontend:** Blade Templates (with potential for React/Vue components for dynamic features).
- **Design System:** Inter Font, Light Mode, Primary Color `#1754cf`. (See Stitch Design `DBIM`).

## 3. Core Functional Requirements

### 🎥 Live Stream Hub
- **Frontend:** Integrated player for live broadcast.
- **Backend:**
  - API Key generation for streaming software (OBS, vMix, etc.).
  - **Multi-stream Support:** Interface to manage and transmit streams to external platforms (Facebook, YouTube, TikTok) via server-side relay or API integration.

### 📅 Event Management
- **Calendar:** "Current Year" calendar displaying all events, activities, and programs.
- **Events Page:** Dedicated listing for Upcoming and Past events.
- **Features:** Detailed views, potential for registration/ticketing.

### 🎓 Learning Management System (LMS)
- **Courses:** Support for Paid and Free courses.
- **Instructors:** Multi-instructor support.
- **Live Classes:** Zoom-like integrated live streaming for:
  - Paid/Free live classes.
  - One-on-One mentorship/meetings.

### 🔐 Authentication & Security
- **Modern Auth:** enhanced login/register pages.
- **Social Login:** Google Auth integration (and others).
- **RBAC (Role-Based Access Control):**
  - **Admin:** Full System Control.
  - **Media/Technical Team:** Stream & Content management.
  - **Finance:** Store & Donation management.
  - **Instructors:** Course & Student management.

### 🛒 Store (E-Commerce)
- **Materials:** Digital and Physical church material sales.
- **Checkout:** Secure payment gateway integration.

### 📚 Digital Publishing & Reading
- **Book Publishing:**
  - In-app book writing system.
  - Upload support for existing books (PDF/Secure Formats).
  - Admin review workflow before approval.
- **Reading Experience:**
  - In-app reader.
  - **Read Aloud:** Audio reading feature (Text-to-Speech).

## 4. Design References (Stitch)
**Project ID:** `projects/17224230738616521384`
- **Live Stream & Chat:** Desktop Interface.
- **Booking:** One-on-One Session UI.
- **Admin Dashboard:** Version 3 Overview.
- **Control Room:** Media & Events management console.

## 5. Development Roadmap & Progress

### Phase 1: Foundation & Auth
- [x] Project Structure Setup (Laravel 11)
- [x] Database Schema Initialization (Users, Roles)
- [x] UI Foundation (Blade Layouts, Inter Font)
- [x] Implement Modern Auth & Social Login
- [x] Setup Role-Based Access Control (RBAC)

### Phase 2: Core Features (Events & Content)
- [x] Event Calendar Module (Frontend: FullCalendar, Backend: Existing API)
- [x] Events Page (Listing & Details)
- [ ] basic CMS for static pages (About, Contact)

### Phase 3: LMS & Live Streaming
- [ ] Course Management System (Backend)
- [ ] Student Dashboard (Frontend)
- [ ] Live Stream Ingestion & Player
- [ ] Multi-stream Relay System

### Phase 4: Store & Publishing
- [ ] E-commerce Storefront & Cart
- [ ] Book Reader & Writer Interface
- [ ] Audio Reading Implementation

### Phase 5: Polish & Launch
- [ ] Mobile Responsiveness Testing
- [ ] Performance Optimization
- [ ] SEO & Analytics

---
*This file serves as the central documentation for the DBIM project. Update it as features are implemented or requirements change.*
