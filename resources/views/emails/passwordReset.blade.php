<!DOCTYPE html>
<html>
<head>
    <title>Redefinição de Senha</title>
</head>
<body>
    <p>Olá,</p>
    <p>Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.</p>
    <p>Seu token de redefinição de senha é:</p>
    <p><strong>{{ $token }}</strong></p>
    <p>Para redefinir sua senha, você pode usar o seguinte link:</p>
    <p><a href="{{ url('password/reset', $token) }}">Redefinir Senha</a></p>
    <p>Se você não solicitou uma redefinição de senha, por favor, ignore este e-mail.</p>
    <p>Atenciosamente,<br>Equipe de Suporte</p>
</body>
</html>
