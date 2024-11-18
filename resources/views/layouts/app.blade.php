<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PDAM')</title>
    <link rel="icon" href="{{URL::asset('water_icon.png')}}" type="image/png">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Include Datatables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ URL::asset('/css/css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('/css/style.css')}}">
    <meta name="robots" content="noindex, follow">
    <script defer="" referrerpolicy="origin" src="{{ URL::asset('/css/s.js.download')}}"></script>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fas fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <div class="p-4">
                <h1><a href="/" class="logo">PDAM
                        <span>Distribusi Air</span></a></h1>
                <ul class="list-unstyled components mb-5">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('transaksi.index')}}"><i class="fas fa-receipt me-1"></i> Transactions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sumber.index') }}"><i class="fas fa-water"></i> Sumber</a>
                    </li>
                </ul>
                <div class="mb-5">
                    @auth
                    <a class="nav-link btn-primary" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @endauth
                </div>
                <div class="footer">
                    <p>
                        Copyright ©
                        <script>document.write(new Date().getFullYear());</script> All rights reserved | dxnn
                        <i class="icon-heart" aria-hidden="true">
                    </p>
                </div>
            </div>
        </nav>

        <div id="content" class="p-4 p-md-5 pt-5 ms-1">
            @yield('content')
        </div>
    </div>
    <script src="{{ URL::asset('./css/jquery.min.js.download')}}"></script>
    <script src="{{ URL::asset('./css/popper.js.download')}}"></script>
    <script src="{{ URL::asset('./css/bootstrap.min.js.download')}}"></script>
    <script src="./css/main.js.download"></script>
    <script defer="" src="{{ URL::asset('/css/vcd15cbe7772f49c399c6a5babf22c1241717689176015')}}"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon="{&quot;rayId&quot;:&quot;8bece7f33ab57d66&quot;,&quot;serverTiming&quot;:{&quot;name&quot;:{&quot;cfL4&quot;:true}},&quot;version&quot;:&quot;2024.8.0&quot;,&quot;token&quot;:&quot;cd0b4b3a733644fc843ef0b185f98241&quot;}"
        crossorigin="anonymous"></script>
    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        $(document).ready(function () {
            $('#transaksiTable').DataTable({
                "order": [], // Disable initial sorting
                "paging": true,
                "searching": true,
                "info": true,
                "lengthChange": false,
                "responsive": true
            });

            $('#sumberTable').DataTable({
                "responsive": true,
                "order": [], // Disable initial sorting
                "paging": true,
                "searching": true,
                "info": true,
                "lengthChange": false,
                "buttons": ['copy', 'csv', 'pdf']
            });

        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    var form = this.closest('form');
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: "Apakah Anda yakin ingin menghapus data ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });


        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    var form = this.closest('form');
                    Swal.fire({
                        title: 'Konfirmasi Edit',
                        text: "Apakah Anda yakin ingin menyimpan perubahan ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Simpan Perubahan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

    </script>
</body>

</html>