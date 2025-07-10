<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Learner Progress Dashboard</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Dashboard</a>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
