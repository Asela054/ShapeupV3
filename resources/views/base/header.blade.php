<!-- DESKTOP TOP BAR HEADER -->
<header class="designer-desktop-header">
    <!-- Left side (Date & Time) -->
    <div class="d-flex align-items-center flex-grow-1">
        <div class="header-clock-pill">
            <i data-lucide="clock" class="clock-icon"></i>
            <div class="d-flex align-items-center gap-2 text-sm">
                <span id="currentDate" class="clock-date"></span>
                <span class="clock-divider">|</span>
                <span id="currentTime" class="clock-time"></span>
            </div>
        </div>
    </div>

    <!-- Right side (Actions & Profile) -->
    <div class="header-right-actions">
        <!-- Notifications -->
        <button type="button" class="header-icon-btn" title="Notifications">
            <i data-lucide="bell" style="width: 20px; height: 20px;"></i>
            <span class="pulse-badge">
                <span class="pulse-ring"></span>
                <span class="pulse-dot"></span>
            </span>
        </button>

        <!-- Settings -->
        <button type="button" class="header-icon-btn" title="Settings">
            <i data-lucide="settings" style="width: 20px; height: 20px;"></i>
        </button>

        <!-- Divider -->
        <div class="header-vertical-divider"></div>

        <!-- Profile Dropdown -->
        <div class="dropdown">
            <button class="header-user-btn dropdown-toggle text-start border-0 bg-transparent p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar-img d-flex align-items-center justify-content-center bg-primary text-white fw-bold">
                    {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 2)) : 'AU' }}
                </div>
                <div class="user-text-meta ms-2">
                    <div class="user-text-name">{{ Auth::check() ? Auth::user()->name : 'Jane Doe' }}</div>
                    <div class="user-text-role">HR Manager</div>
                </div>
                <i data-lucide="chevron-down" class="user-chevron-down ms-1"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow mt-2">
                <li class="px-3 py-2">
                    <div class="fw-bold text-dark">{{ Auth::check() ? Auth::user()->name : 'Jane Doe' }}</div>
                    <div class="text-muted fs-7">{{ Auth::check() ? Auth::user()->email : 'jane@example.com' }}</div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">My Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li class="px-3 py-1">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light-danger text-danger w-100">Sign Out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>