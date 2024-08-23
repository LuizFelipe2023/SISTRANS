@component('mail::message')
# Redefinição de Senha

Olá,

Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.

Seu token de redefinição de senha é:

**{{ $token }}**

Para redefinir sua senha, você pode usar o seguinte link:

@component('mail::button', ['url' => url('/token/' . $email . '?token=' . $token)])
Redefinir Senha
@endcomponent

Se você não solicitou uma redefinição de senha, por favor, ignore este e-mail.

Atenciosamente,<br>
Equipe de Suporte do Sistrans
@endcomponent
