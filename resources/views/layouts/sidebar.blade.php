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
            <li class="nav-label">Pengaturan</li>
            <li>
                <a href="{{ url('/parameter') }}" aria-expanded="false">
                    <i class="fa fa-list menu-icon"></i><span class="nav-text">Parameter</span>
                </a>
            </li>
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
