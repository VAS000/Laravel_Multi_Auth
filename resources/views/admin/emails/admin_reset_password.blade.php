@component('mail::message')
#Reset Admin Password
<br>
Welcome {{ $data['admin']->name }}
@component('mail::button', ['url' => admin_url('reset/password/' . $data['token'])])
Reset Password
@endcomponent

Or copy the link bellow <br>

<a href="{{ admin_url('reset/password/' . $data['token']) }}">{{ admin_url('reset/password/' . $data['token']) }}</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
