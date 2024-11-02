<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Lazismu</title>
    @include('includes.head')
    @include('includes.header')
    <!-- Link ke file CSS custom -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            @include('includes.sidebar')
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <main id="main" class="main">
                <div class="pagetitle">
                    <h1>Admin Lazismu</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active">Lazismu</li>
                        </ol>
                    </nav>
                </div>
                <!-- End Page Title -->

                <!-- Konten utama lainnya bisa ditambahkan di sini -->
            </main>
            <!-- Footer -->
            <footer id="footer" class="footer">
                <div class="credits">
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </footer>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>
