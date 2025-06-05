<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walsa Hotel - Dashboard Client</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background-color: white;
            width: 220px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .hotel-logo {
            color: #8257E5;
            padding: 20px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .menu-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            color: #333;
            transition: all 0.3s;
        }
        .menu-item:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }
        .menu-item.active {
            background-color: #f0f0f0;
            border-left: 4px solid #8257E5;
        }
        .menu-item i {
            width: 24px;
            margin-right: 15px;
        }
        .search-bar input {
            background-color: #f5f5f5;
            border: none;
            border-radius: 20px;
            padding: 10px 15px;
        }
        .search-icon {
            position: absolute;
            right: 20px;
            top: 10px;
            color: #777;
        }
        .add-button {
            background-color: #8257E5;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
        }
        .table-header {
            background-color: #FFF8E1;
            border-radius: 10px 10px 0 0;
        }
        .reservation-table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        .status-confirmed {
            background-color: #E1F5FE;
            color: #0288D1;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
        }
        .action-button {
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            margin: 0 5px;
        }
        .notification-icon, .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
        }
        .logo-decoration {
            width: 70px;
            height: 70px;
            position: relative;
        }
        .logo-decoration:before, .logo-decoration:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            border: 2px solid #8257E5;
            opacity: 0.3;
        }
        .logo-decoration:before {
            top: -10px;
            left: -10px;
            border-radius: 50% 50% 0 50%;
        }
        .logo-decoration:after {
            bottom: -10px;
            right: -10px;
            border-radius: 50% 0 50% 50%;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="hotel-logo">
            <div class="logo-decoration mx-auto">
                <i class="fas fa-bed text-3xl"></i>
            </div>
            <div class="mt-2">WALSA HOTEL</div>
            <div class="text-xs text-gray-500">Stay at the best</div>
        </div>
        
        <div class="menu">
            <div class="menu-item active">
                <i class="fas fa-bookmark"></i>
                <span>my reservations</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-door-open"></i>
                <span>Rooms</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-concierge-bell"></i>
                <span>hotel services</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-calendar"></i>
                <span>calendar</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-star"></i>
                <span>Review</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Header Section -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h2 class="text-2xl font-bold">My Reservations</h2>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-inline-block me-3 notification-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="d-inline-block profile-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="ms-2">lara loyalt</span>
                </div>
            </div>

            <!-- Search and Add Button Row -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-8 position-relative">
                    <input type="text" class="form-control search-bar" placeholder="Search ...">
                    <i class="fas fa-search search-icon"></i>
                </div>
                <div class="col-md-4 text-end">
                    <button class="add-button">
                        <i class="fas fa-plus me-2"></i>Add Broking
                    </button>
                </div>
            </div>

            <!-- Reservations Table -->
            <div class="reservation-table">
                <table class="table table-hover mb-0">
                    <thead class="table-header">
                        <tr>
                            <th>Room Number</th>
                            <th>Room Type</th>
                            <th>Duration</th>
                            <th>Check in & Chek out</th>
                            <th>satus</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Standart 304</td>
                            <td>Single</td>
                            <td>3 night</td>
                            <td>june 19, 2025 - june 22, 2025</td>
                            <td><span class="status-confirmed">Confirmed</span></td>
                            <td>
                                <button class="action-button">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-button">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-button">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>