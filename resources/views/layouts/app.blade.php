<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>.:: Booj-Books ::.</title>

    <!-- Favicon icon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Icons -->
    <script type="module" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body>
    <div id="app">
        @include('layouts.nav')

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    @if (session()->has('success'))
    <script>
        const notyf = new Notyf({dismissible: true})
        notyf.success('{{ session('success') }}')
    </script>
    @endif

    @if(session()->has('error'))
        <script>
            const notyf = new Notyf({
                dismissible: true,
                duration: 5000,
                position: {
                    x: 'right',
                    y: 'top',
                }
            })
            notyf.error('{{ session('error') }}')
        </script>
    @endif

    <script>
        /* Simple function to retrieve data url from file */
        function fileToDataUrl(event, callback) {
            if (! event.target.files.length) return

            let file = event.target.files[0],
                reader = new FileReader()

            reader.readAsDataURL(file)
            reader.onload = e => callback(e.target.result)
        }
    </script>
    <footer class="footer">
        @include('layouts.footer')
    </footer>
</body>
</html>
