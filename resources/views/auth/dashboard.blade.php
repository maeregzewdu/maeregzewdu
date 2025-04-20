<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Maereg Zewdu</title>
    <link rel="icon" href="images/logo/favicon.svg" type="image/svg+xml">
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
            background-color: #0F172A;
        }
        h1, h2, h3, h4, h5, h6, a, button, label {
            font-family: 'Russo One', sans-serif;
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body>
    <!-- Notification Component Mount Point -->
    <div id="notification-app"></div>
    
    <!-- Flash Messages Container (Hidden) -->
    @if(session('success'))
        <div id="laravel-success-message" data-message="{{ session('success') }}" class="hidden"></div>
    @endif

    <!-- Dashboard Component Mount Point -->
    <div id="dashboard-app"></div>

    <!-- Script to pass Laravel data to Vue -->
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
