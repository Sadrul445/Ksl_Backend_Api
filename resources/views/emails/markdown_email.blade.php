@component('mail::message')
<img src="https://kslbd.net/assets/ksl-logo.svg" class="logo" alt="Laravel Logo">
<div class="container-fluid" style="text-align: center">
    <h3> KSL User Review</h3>
</div>


<b>Name:</b> {{ $name }}<br>
<b>Email:</b> {{ $email }}<br>
<b>Phone Number:</b> {{ $phone_number }}<br>
<b>Content:</b> {{ $content }}

@component('mail::button', ['url' => 'https://kslbd.net'])
Visit our website
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
