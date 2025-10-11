<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand"
            href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard')) : '/' }}">
            <i class="bi bi-chat-dots-fill"></i> NusaBERT Chatbot
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            @auth
                <ul class="navbar-nav ms-auto">
                    @if (auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}"
                                href="{{ route('admin.logs.index') }}">
                                <i class="bi bi-activity"></i> Logs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}"
                                href="{{ route('admin.profile.edit') }}">
                                <i class="bi bi-person-circle"></i> Profile
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}"
                                href="{{ route('chat.index') }}">
                                <i class="bi bi-chat-left-text"></i> Chat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                                href="{{ route('profile.edit') }}">
                                <i class="bi bi-person"></i> Profile
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-badge"></i> {{ auth()->user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">
                                    <i class="bi bi-shield-check"></i>
                                    {{ auth()->user()->role->role }}
                                </h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @if (auth()->user()->isAdmin())
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                                        <i class="bi bi-gear"></i> Settings
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person-gear"></i> Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('change-password') }}">
                                        <i class="bi bi-key"></i> Change Password
                                    </a>
                                </li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
