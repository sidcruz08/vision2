<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/patients">Patients</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/visits">Visits</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/diagnoses">Diagnoses</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/treatments">Treatments</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="/claim-items">Claim-items</a>
                </li>
                <!-- <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
                </li> -->
            </ul>
            </div>
        </div>
    </nav>
    <div class="container py-4">
        @yield('content')
    </div>
</body>
</html>
