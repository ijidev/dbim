@extends('admin.layouts.app')

@section('title', 'Site Settings')

@section('content')
    <div style="max-width: 800px;">
        <div style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Site Settings</h2>
            <p style="color: #64748b; margin: 0.25rem 0 0;">Manage global website configuration and contact information</p>
        </div>

        @if(session('success'))
            <div style="background: #f0fdf4; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
                {{ session('success') }}
            </div>
        @endif

        <div class="data-card" style="padding: 2rem;">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                
                <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1.5rem; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">General Information</h3>
                
                <div class="form-group">
                    <label class="form-label">Site Name</label>
                    <input type="text" name="site_name" class="form-input" value="{{ $settings['site_name'] ?? 'DBIM' }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Mission Statement</label>
                    <textarea name="mission_statement" class="form-input" rows="3">{{ $settings['mission_statement'] ?? "Raising gods from amongst men on earth for Christ" }}</textarea>
                </div>

                <h3 style="font-size: 1.125rem; font-weight: 600; margin: 2rem 0 1.5rem; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">Contact Details</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Contact Email</label>
                        <input type="email" name="contact_email" class="form-input" value="{{ $settings['contact_email'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-input" value="{{ $settings['contact_phone'] ?? '' }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Office Address</label>
                    <textarea name="contact_address" class="form-input" rows="2">{{ $settings['contact_address'] ?? '' }}</textarea>
                </div>

                <h3 style="font-size: 1.125rem; font-weight: 600; margin: 2rem 0 1.5rem; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem;">Social Links</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Facebook URL</label>
                        <input type="url" name="facebook_url" class="form-input" value="{{ $settings['facebook_url'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Instagram URL</label>
                        <input type="url" name="instagram_url" class="form-input" value="{{ $settings['instagram_url'] ?? '' }}">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem;">Save Settings</button>
                    <button type="reset" class="btn btn-outline">Reset</button>
                </div>
            </form>
        </div>
    </div>
@endsection
