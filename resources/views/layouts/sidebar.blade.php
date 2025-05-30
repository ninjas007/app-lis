<!--**********************************
            Sidebar start
        ***********************************-->
<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">MENU UTAMA</li>
            <li>
                <a href="{{ url('/home') }}" aria-expanded="false">
                    <i class="fa fa-dashboard menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/pasien') }}" aria-expanded="false">
                    <i class="fa fa-user menu-icon"></i><span class="nav-text">Pasien</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/hasil') }}" aria-expanded="false">
                    <i class="fa fa-medkit menu-icon"></i><span class="nav-text">Hasil Pemeriksaan</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-envelope menu-icon"></i> <span class="nav-text">Laporan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('laporan/kunjungan-pasien') }}">Kunjungan Pasien</a></li>
                    <li><a href="{{ url('laporan/hasil') }}">Hasil</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-file menu-icon"></i> <span class="nav-text">Master</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('master/paket') }}">Paket</a></li>
                    <li><a href="{{ url('master/dokter') }}">Dokter</a></li>
                    <li><a href="{{ url('master/pasien') }}">Pasien</a></li>
                    <li><a href="{{ url('master/petugas') }}">Petugas</a></li>
                    <li><a href="{{ url('master/ruangan') }}">Ruangan</a></li>
                    <li><a href="{{ url('master/status-pasien') }}">Status Pasien</a></li>
                    <li><a href="{{ url('master/jenis-layanan') }}">Jenis Layanan</a></li>
                    <li><a href="{{ url('/parameter') }}">Parameter</a></li>
                </ul>
            </li>
            <li class="nav-label">Pengaturan</li>
            {{-- <li>
                <a href="{{ url('/template') }}" aria-expanded="false">
                    <i class="fa fa-briefcase menu-icon"></i><span class="nav-text">Template</span>
                </a>
            </li> --}}
            <li>
                <a href="{{ url('/setting') }}" aria-expanded="false">
                    <i class="fa fa-gears menu-icon"></i><span class="nav-text">Setting</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/tentang') }}" aria-expanded="false">
                    <i class="fa fa-paperclip menu-icon"></i><span class="nav-text">Tentang</span>
                </a>
            </li>

            {{-- divider --}}
            <div class="divider border mt-2"></div>

            {{-- logout --}}
            <li>
                <a href="javascript:void()" onclick="logout()" aria-expanded="false">
                    <i class="fa fa-sign-out menu-icon text-danger"></i><span class="nav-text text-danger">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>


<form action="{{ url('/logout') }}" method="POST" id="logout-form">
    @csrf
</form>

<!--**********************************
    Sidebar end
***********************************-->
