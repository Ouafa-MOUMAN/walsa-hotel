<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Grand Hotel Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Styles personnalisés */
        body {
            overflow-x: hidden;
        }

        .sidebar {
            background-color: #ffffff;
            height: 100vh;
            position: fixed;
            width: 200px;
            box-shadow: 0px 0 10px 10px rgba(139, 69, 19, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
            left: 0;
            top: 60px;
        }

        .sidebar.collapsed {
            width: 50px;
        }

        .sidebar-item {
            padding: 10px;
            text-align: left;
            color: #1d1d1d;
            text-decoration: none;
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            transition: background-color 0.3s;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-item:hover, .sidebar-item.active {
            background-color: #fcfcfc;
            color: #8b4513;
            text-decoration: none;
        }

        .sidebar-icon {
            font-size: 24px;
            margin-right: 10px;
            min-width: 24px;
            text-align: center;
        }

        .sidebar-text {
            transition: opacity 0.3s, visibility 0.3s;
        }

        .sidebar.collapsed .sidebar-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
        }

        .main-content {
            margin-left: 200px;
            padding: 20px;
            background-color: #ffffff;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
            margin-top: 60px;
        }

        .main-content.expanded {
            margin-left: 50px;
        }

        .navbar {
            background-color: white;
            padding: 0.5rem 1rem;
            position: fixed;
            width: 100%;
            z-index: 1030;
            left: 0;
            top: 0;
            height: 60px;
        }

        .navbar-container {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .logo-container {
            display: flex;
            align-items: center;
            padding-right: 20px;
            flex-shrink: 0;
        }

        .navbar-content {
            flex-grow: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-left: 20px;
        }

        .logo {
            height: 35px;
            width: 35px;
            background: linear-gradient(135deg, #8b4513, #d2691e);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .profile-icon {
            width: 35px;
            height: 35px;
            background-color: #8b4513;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-badge {
            position: relative;
        }

        .badge-number {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-sidebar {
            cursor: pointer;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .toggle-sidebar:hover {
            background-color: #f8f9fa;
        }

        .brand-primary {
            color: #8b4513 !important;
        }

        .shadow-bottom {
            box-shadow: 0 6px 6px -2px rgba(139, 69, 19, 0.1);
        }

        @media (max-width: 767.98px) {
            .sidebar {
                width: 70px;
                top: 50px;
            }
            .main-content {
                margin-left: 70px;
                margin-top: 50px;
            }
            .navbar {
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-white shadow-bottom">
        <div class="navbar-container">
            <div class="logo-container">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <div class="d-flex align-items-center">
                        <div class="logo">H</div>
                        <div class="ms-2">
                            <span class="brand-primary fw-bold" style="font-size: 18px;">GRAND HOTEL</span>
                            <span class="text-muted d-block" style="font-size: 12px;">ADMINISTRATION</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="navbar-content">
                <div class="toggle-sidebar" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </div>

                <div class="d-flex align-items-center">
                    <div class="notification-badge me-2 me-lg-3">
                        <i class="bi bi-bell fs-5 text-black"></i>
                        <span class="badge-number">3</span>
                    </div>
                    <div class="d-flex align-items-center me-2 me-lg-3">
                       <div class="dropdown">
                                <div class="profile-icon mx-2 text-white fw-bold text-center"
                                    id="profileDropdown"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    style="width: 35px; height: 35px; border-radius: 50%; line-height: 35px;">
                                    A
                                </div>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                    <li class="dropdown-item">Hello Admin</li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Paramètres</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-box-arrow-right"></i> Déconnexion
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="mt-3">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house-door sidebar-icon"></i>
                <span class="sidebar-text">Tableau de bord</span>
            </a>
           
            <a href="{{ route('admin.chambres.index') }}" class="sidebar-item {{ request()->routeIs('admin.chambres.*') ? 'active' : '' }}">
                <i class="bi bi-door-open sidebar-icon"></i>
                <span class="sidebar-text">Gestion des chambres</span>
            </a>

            <a href="{{ route('admin.reservations.index') }}" class="sidebar-item {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check sidebar-icon"></i>
                <span class="sidebar-text">Réservations</span>
            </a>

            <a href="{{ route('admin.clients.index') }}" class="sidebar-item {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                <i class="bi bi-people sidebar-icon"></i>
                <span class="sidebar-text">Clients</span>
            </a>

            <a href="{{ route('admin.admins.index') }}" class="sidebar-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock sidebar-icon"></i>
                <span class="sidebar-text">Gestion des admins</span>
            </a>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="main-content" id="mainContent">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            let sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            if (sidebarCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }

            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');

                sidebarCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', sidebarCollapsed);

                const toggleIcon = toggleSidebar.querySelector('i');
                if (sidebarCollapsed) {
                    toggleIcon.classList.remove('bi-list');
                    toggleIcon.classList.add('bi-list-nested');
                } else {
                    toggleIcon.classList.remove('bi-list-nested');
                    toggleIcon.classList.add('bi-list');
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>