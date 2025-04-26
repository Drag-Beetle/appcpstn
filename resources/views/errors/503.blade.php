<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>We'll be back soon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f9fafb;
            color: #1f2937;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 1.5rem;
        }
        .message {
            text-align: center;
        }
        .title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .sub {
            color: #6b7280;
        }
    </style>
</head>
<body>
    <img src="{{ asset('logo-dark.png') }}" alt="Site Logo" class="logo"> {{-- customize path --}}
    <div class="message">
        <div class="title">We’re currently doing maintenance.</div>
        <div class="sub">Please check back later.</div>
    </div>
</body>
</html>
