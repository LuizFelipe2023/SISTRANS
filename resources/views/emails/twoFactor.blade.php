@component('mail::message')
# Autenticação de Dois Fatores

Olá,

Seu código de autenticação de dois fatores é: **{{ $code }}**

Por favor, insira este código no formulário para continuar o login.

Se você não solicitou isso, ignore este e-mail.

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
