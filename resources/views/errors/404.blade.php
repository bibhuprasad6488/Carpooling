<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(95deg, #000 0%, #0369a1 100%) !important;
            font-family: Arial, sans-serif;
        }

        .error-container {
            text-align: center;
            max-width: 600px;
            padding: 40px;
        }

        .error-title {
            font-size: 32px;
            font-weight: 700;
            margin-top: 15px;
            color: #ffffff;
        }

        .error-text {
            color: #6c757d;
            margin: 15px 0 30px;
            font-size: 18px;
        }

        .btn-home {
            padding: 12px 30px;
            border-radius: 50px;
        }

        .svg-404 {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .num4 {
            stroke-dasharray: 300;
            stroke-dashoffset: 300;
            animation: draw 2s ease forwards;
        }

        .num0 {
            stroke-dasharray: 400;
            stroke-dashoffset: 400;
            animation: draw 2s ease forwards .5s;
        }

        .floating-dot {
            animation: float 2s ease-in-out infinite;
        }

        @keyframes draw {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }
    </style>
</head>

<body>

    <div class="error-container">
        {{-- <img src="{{ asset('images/404.svg') }}" alt="404" class="error-image"> --}}
        <div class="svg-404">
            <svg width="350" height="220" viewBox="0 0 320 220" xmlns="http://www.w3.org/2000/svg">

                <!-- Left 4 -->
                <path class="num4" d="M50 40 L50 120 L95 120 M95 40 L95 180" fill="none" stroke="#0d6efd"
                    stroke-width="20" stroke-linecap="round" stroke-linejoin="round" />

                <!-- 0 -->
                <ellipse class="num0" cx="160" cy="110" rx="40" ry="70" fill="none"
                    stroke="#0d6efd" stroke-width="20" />

                <!-- Right 4 -->
                <path class="num4" d="M225 40 L225 120 L270 120 M270 40 L270 180" fill="none" stroke="#0d6efd"
                    stroke-width="20" stroke-linecap="round" stroke-linejoin="round" />

                <!-- Floating circle -->
                <circle class="floating-dot" cx="160" cy="20" r="8" fill="#0d6efd" />
            </svg>
        </div>


        <h1 class="error-title">Page Not Found</h1>

        <p class="error-text">
            The page you are looking for might have been removed,
            had its name changed, or is temporarily unavailable.
        </p>

        <button onclick="history.back()" class="btn btn-primary btn-home">
            ← Go Back
        </button>
    </div>
    <script>
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = "{{ url('/') }}";
            }
        }
    </script>
</body>

</html>
