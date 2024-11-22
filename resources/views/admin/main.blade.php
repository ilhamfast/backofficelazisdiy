<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite('resources/css/app.css') --}}
    <title>Dashboard</title>
</head>

<body class="h-screen bg-gray-100">
    <div class="flex h-full">
        <aside class="w-56 h-full bg-white shadow-md fixed">
            @include('includes.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 pl-56">
            <!-- Header -->
            <header class="bg-white p-4 shadow-md mb-10">
                @include('includes.header')
            </header>

            <!-- Content -->
            <main class="p-4 mt-16"> <!-- Padding top for the main content -->
                <p>Isi konten utama di sini...</p>
            </main>
        </div>
    </div>
</body>

</html>
