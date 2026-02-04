@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<!-- Hero -->
<div style="background-color: white; border-bottom: 1px solid #e2e8f0; padding: 5rem 1rem; text-align: center; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 50%; height: 200%; background: radial-gradient(circle, rgba(245, 158, 11, 0.05) 0%, transparent 70%); z-index: 0;"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <h1 style="font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 800; color: #1e293b; letter-spacing: -0.05em; margin-bottom: 1rem;">Get in Touch</h1>
        <p style="color: #64748b; max-width: 600px; margin: 0 auto; font-size: 1.25rem;">Have questions or want to learn more? We'd love to hear from you.</p>
    </div>
</div>

<div class="container" style="padding: 5rem 1.5rem;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 4rem;">
        <!-- Contact Info -->
        <div>
            <div class="info-group">
                <h3>📍 Main Office</h3>
                <p>
                    1600 Amphitheatre Parkway<br>
                    Mountain View, CA 94043 US<br>
                    <span class="sub-text">Mon-Thur 8:30am – 4:30pm</span>
                </p>
            </div>

            <div class="info-group">
                <h3>📞 Contact Info</h3>
                <p>
                    <a href="mailto:info@dbim.com" class="contact-link">info@dbim.com</a><br>
                    <a href="tel:+1975432345" class="contact-link">+197 543 2345</a>
                </p>
            </div>

            <div class="info-group">
                <h3>🌐 Follow Us</h3>
                <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                    <a href="#" class="social-btn">📘</a>
                    <a href="#" class="social-btn">🐦</a>
                    <a href="#" class="social-btn">📸</a>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div style="background: white; padding: 2.5rem; border-radius: 1.5rem; box-shadow: var(--shadow-lg); border: 1px solid #e2e8f0;">
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 2rem;">Send a Message</h3>
            <form action="#" method="POST" style="display: grid; gap: 1.5rem;">
                @csrf
                <div>
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Message</label>
                    <textarea name="message" rows="5" required class="form-input"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">Send Message</button>
            </form>
        </div>
    </div>
</div>

<style>
    .info-group { margin-bottom: 3rem; }
    .info-group h3 { font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
    .info-group p { color: #475569; line-height: 1.6; font-size: 1.1rem; }
    .sub-text { display: block; margin-top: 0.5rem; color: #94a3b8; font-size: 0.9rem; }
    
    .contact-link { color: var(--primary); font-weight: 600; text-decoration: none; }
    .contact-link:hover { text-decoration: underline; }

    .social-btn {
        width: 48px; height: 48px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.25rem;
        transition: all 0.2s;
    }
    .social-btn:hover { background: var(--primary); color: white; transform: translateY(-3px); }

    .form-label { display: block; font-size: 0.875rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem; }
    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        font-family: inherit;
        font-size: 1rem;
        transition: all 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }
</style>
@endsection
