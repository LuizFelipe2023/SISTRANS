@component('mail::message')
# Verificação de E-mail

Olá,

Clique no botão abaixo para verificar seu e-mail:

@component('mail::button', ['url' => route('auth.verifyEmailToken', $token)])
Verificar E-mail
@endcomponent

Se você não solicitou esta verificação, ignore este e-mail.

Obrigado,
{{ config('app.name') }}
@endcomponent
