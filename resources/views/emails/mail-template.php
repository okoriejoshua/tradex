@component('mail::message')
# New Contact Form Submission

**Subject:** {{ $data['subject'] }}

**Content:**
{{ $data['content'] }}

**From:** {{ $data['receiver_email'] }}

@endcomponent