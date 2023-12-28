<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo me-1">
                <img src="/assets/img/logo/1.png" width="40" alt="">
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2">SIAKAD</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item open">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>

        <!-- Layouts -->
        @if (auth()->user()->role == 'admin')
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons mdi mdi-database"></i>
                    <div data-i18n="data master">Data master</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('users') }}" class="menu-link">
                            <div data-i18n="users">users</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('siswa.index') }}" class="menu-link">
                            <div data-i18n="siswa">siswa</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('guru.index') }}" class="menu-link">
                            <div data-i18n="guru">guru</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('kelas.index') }}" class="menu-link">
                            <div data-i18n="kelas">kelas</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('mapel.index') }}" class="menu-link">
                            <div data-i18n="Mapel">Mapel</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('jadwal.index') }}" class="menu-link">
                            <div data-i18n="jadwal">jadwal</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @if (auth()->user()->role == 'siswa')
            <li class="menu-item">
                <a href="{{ route('siswa.jadwal') }}" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-calendar-blank-outline"></i>
                    <div data-i18n="Calendar">Jadwal</div>
                    {{-- <div class="badge bg-label-primary fs-tiny rounded-pill ms-auto">Pro</div> --}}
                </a>
            </li>
        @endif
        @if (auth()->user()->role == 'guru')
            <li class="menu-item">
                <a href="{{ route('guru.jadwal') }}" class="menu-link">
                    <i class="menu-icon tf-icons mdi mdi-calendar-blank-outline"></i>
                    <div data-i18n="Calendar">Jadwal</div>
                    {{-- <div class="badge bg-label-primary fs-tiny rounded-pill ms-auto">Pro</div> --}}
                </a>
            </li>
        @endif
        <!-- Pages -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-account-outline"></i>
                <div data-i18n="Account Settings">Account</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('account.profile') }}" class="menu-link">
                        <div data-i18n="Account">Profile</div>
                    </a>
                </li>
                @if (auth()->user()->role == 'siswa' && auth()->user()->status === 'aktif')
                    <li class="menu-item">
                        <a href="pages-account-settings-notifications.html" class="menu-link">
                            <div data-i18n="Notifications">Orang tua</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('siswa.kelas') }}" class="menu-link">
                            <div data-i18n="Connections">Kelas</div>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-cog"></i>
                <div data-i18n="Authentications">Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('settings.change_password') }}" class="menu-link">
                        <div data-i18n="Basic">Change password</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('settings.change_email') }}" class="menu-link">
                        <div data-i18n="Basic">Change email</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="{{ route('logout') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-logout"></i>
                <div data-i18n="Misc">Logout</div>
            </a>
        </li>
    </ul>
</aside>
