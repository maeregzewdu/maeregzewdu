<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Maereg Zewdu - Create Project</title>
    <meta name="description" content="Crafting modern, responsive websites that help businesses grow online. Let's bring your digital ideas to life." />
    <meta property="og:title" content="Maereg Zewdu – Web Designer and Developer" />
    <meta property="og:description" content="Crafting modern, responsive websites that help businesses grow online." />
    <meta property="og:url" content="https://maeregzewdu.com" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ url('images/logo/favicon.svg') }}" />
    <link rel="icon" type="image/png" href="{{ url('images/logo/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ url('images/logo/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ url('images/logo/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('images/logo/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="Maereg" />
    <link rel="manifest" href="{{ url('images/logo/site.webmanifest') }}" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Russo+One&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        h1, h2, h3, h4, h5, h6, a, button, .price, #loading-status, #font-russo {
            font-family: 'Russo One', sans-serif;
        }
    </style>
</head>

<body class="bg-[#0F172A] text-white">

    <!-- Flash Messages Container (Hidden) -->
    @if(session('success'))
        <div id="laravel-success-message" data-message="{{ session('success') }}" class="hidden"></div>
    @endif

    <div id="project-form-app" 
        @if(isset($project))
        data-project="{{ json_encode($project) }}"
        data-edit-mode="true"
        @endif
    ></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Display success message if exists
            const successMessage = document.getElementById('laravel-success-message');
            if (successMessage && window.showGlobalNotification) {
                window.showGlobalNotification(successMessage.getAttribute('data-message'), 'success');
            }
        });
    </script>

</body>

</html>