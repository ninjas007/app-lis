<!--**********************************
            Sidebar start
        ***********************************-->
<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">MENU</li>
            <li>
                <a href="{{ url('/home') }}" aria-expanded="false">
                    <i class="fa fa-dashboard menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/pasien') }}" aria-expanded="false">
                    <i class="fa fa-users menu-icon"></i><span class="nav-text">Pasien</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/hasil') }}" aria-expanded="false">
                    <i class="fa fa-medkit menu-icon"></i><span class="nav-text">Hasil Pemeriksaan</span>
                </a>
            </li>
            <li class="nav-label">Pengaturan</li>
            <li>
                <a href="{{ url('/template') }}" aria-expanded="false">
                    <i class="fa fa-briefcase menu-icon"></i><span class="nav-text">Template</span>
                </a>
                <a href="{{ url('/sistem') }}" aria-expanded="false">
                    <i class="fa fa-server menu-icon"></i><span class="nav-text">Konfigurasi Sistem</span>
                </a>
                <a href="{{ url('/sistem') }}" aria-expanded="false">
                    <i class="fa fa-cogs menu-icon"></i><span class="nav-text">Konfigurasi Alat</span>
                </a>
            </li>

            {{-- divider --}}
            <div class="divider border"></div>

            {{-- logout --}}
            <li>
                <a href="{{ url('/logout') }}" aria-expanded="false">
                    <i class="fa fa-sign-out menu-icon text-danger"></i><span class="nav-text text-danger">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!--**********************************
                    Sidebar end
                ***********************************-->
