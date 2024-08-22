<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .header-nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-nav a {
            text-decoration: none;
            font-weight: bold;
        }

        .header-nav a:hover {
            text-decoration: underline;
        }

        .logout-span {
            cursor: pointer;
            color: #dc3545;
            font-weight: bold;
        }

        .logout-span:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header class="container-md py-5 px-4 mb-4 border-bottom" id="container-header">
        <div class="d-flex flex-wrap justify-content-center justify-content-lg-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('_4ac0cf13-00f8-42f6-b50b-5a9bf91ce74c.jpg') }}" alt="Logo" style="max-height: 50px;">
                <h1 class="h4 mb-0 text-dark fw-bold ms-3">Sistema de Agendamento Sistrans</h1>
            </div>
            <nav class="mt-3 mt-lg-0">
                <div class="header-nav">
                    <span><a href="{{ route('clientes.index') }}">Clientes</a></span>
                    <span><a href="{{ route('agendamentos.index2') }}">Agendamentos</a></span>
                    <span class="logout-span" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair
                    </span>
                    <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </nav>
        </div>
    </header>

    <main class="container-md mb-5">
        @yield('content')
    </main>

    <footer class="container-md py-4">
        <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0 text-muted">&copy; {{ date('Y') }} Sistema de Agendamento Sistrans. Todos os direitos reservados.</p>
            <ul class="list-unstyled d-flex gap-3 mb-0">
                <li><a href="#" class="text-muted"><i class="bi bi-facebook"></i></a></li>
                <li><a href="#" class="text-muted"><i class="bi bi-twitter"></i></a></li>
                <li><a href="#" class="text-muted"><i class="bi bi-instagram"></i></a></li>
            </ul>
        </div>
    </footer>
</body>

</html>
