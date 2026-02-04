@extends('layouts.app')

@section('content')
<div style="background-color: #fff; border-bottom: 1px solid #e2e8f0; padding: 4rem 1rem; text-align: center;">
    <h1 style="font-size: 3rem; font-weight: 800; color: #1e293b; letter-spacing: -0.05em; margin-bottom: 1rem;">Contact Us</h1>
    <p style="color: #64748b; max-width: 600px; margin: 0 auto; font-size: 1.15rem;">Have questions or want to learn more? We'd love to hear from you.</p>
</div>

<div style="padding: 4rem 1rem; max-width: 1000px; margin: 0 auto;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 4rem;">
        <div>
            <div style="margin-bottom: 2.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Main Office</h3>
                <p style="color: #475569; line-height: 1.6;">
                    1600 Amphitheatre Parkway<br>
                    Mountain View, CA 94043 US<br>
                    <span style="display: block; margin-top: 0.5rem; color: #94a3b8; font-size: 0.9rem;">Mon-Thur 8:30am – 4:30pm</span>
                </p>
            </div>

            <div style="margin-bottom: 2.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Contact Info</h3>
                <p style="color: #475569; line-height: 1.6;">
                    <a href="mailto:info@dbim.com" style="color: var(--primary-color); font-weight: 600;">info@dbim.com</a><br>
                    <a href="tel:+1975432345" style="color: var(--primary-color); font-weight: 600;">+197 543 2345</a>
                </p>
            </div>

            <div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem;">Follow Us</h3>
                <div style="display: flex; gap: 1rem;">
                    <a href="#" style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; transition: background 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">📘</a>
                    <a href="#" style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; transition: background 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">🐦</a>
                    <a href="#" style="width: 40px; height: 40px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; transition: background 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">📸</a>
                </div>
            </div>
        </div>

        <div>
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 2rem;">Send a Message</h3>
            <form action="#" method="POST" style="display: grid; gap: 1.25rem;">
                @csrf
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Full Name</label>
                    <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-family: inherit; font-size: 1rem; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'; this.style.outline='none'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Email Address</label>
                    <input type="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-family: inherit; font-size: 1rem; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary-color)'; this.style.outline='none'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Message</label>
                    <textarea name="message" rows="5" required style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; font-family: inherit; font-size: 1rem; transition: border-color 0.2s; resize: vertical;" onfocus="this.style.borderColor='var(--primary-color)'; this.style.outline='none'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                </div>
                <button type="submit" style="background: var(--primary-color); color: white; padding: 1rem; border: none; border-radius: 0.5rem; font-weight: 700; font-size: 1rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#1a4ebd'" onmouseout="this.style.background='var(--primary-color)'">Send Message</button>
            </form>
        </div>
    </div>
</div>
@endsection
