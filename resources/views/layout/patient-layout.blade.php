<!DOCTYPE html>
<html lang="en">

<head>

    <title>Patient Dashboard - Hospital Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @livewireStyles
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            min-height: 100vh;
            color: white;
            position: fixed;
            width: 250px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .sidebar .nav-link.active {
            background: white;
            color: #3498db;
            font-weight: 600;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 25px;
        }

        /* Main content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Header */
        .header {
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border-left: 4px solid;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card.blue {
            border-left-color: #3498db;
        }

        .stat-card.green {
            border-left-color: #2ecc71;
        }

        .stat-card.orange {
            border-left-color: #f39c12;
        }

        .stat-card.red {
            border-left-color: #e74c3c;
        }

        .stat-icon {
            font-size: 2.5rem;
            color: #ddd;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }



        .badge {
            padding: 5px 10px;
            border-radius: 30px;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        .btn-action {
            padding: 5px 10px;
            margin: 0 2px;
            border-radius: 5px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Cards for sections */
        .section-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        /* Form elements */
        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3498db;
            box-shadow: none;
        }

        .btn-primary {
            background: #3498db;
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-outline-primary {
            border: 1px solid #3498db;
            color: #3498db;
        }

        .btn-outline-primary:hover {
            background: #3498db;
            color: white;
        }

        .btn-danger {
            background: #e74c3c;
            border: none;
        }

        /* List group */
        .list-group-item {
            border: none;
            border-bottom: 1px solid #f0f0f0;
            padding: 12px 15px;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar">
        <div class="p-4 text-center">
            <i class="fa-solid fa-hospital fa-3x mb-3"></i>
            <h5 class="fw-bold">City Hospital</h5>
            <p class="small opacity-75">Patient Panel</p>
        </div>

        <hr class="opacity-25">

        <div class="nav flex-column">
            <a href="#" class="nav-link active" onclick="showSection('dashboard')">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>
            <a href="{{ route('view-doctors') }}" class="nav-link" onclick="showSection('departments')">
                <i class="fa-solid fa-building"></i> View Doctors
            </a>
            <a href="{{ route('view') }}" class="nav-link" onclick="showSection('doctors')">
                <i class="fa-solid fa-user-md"></i> View Appointment
            </a>
            <a href="#schedule" class="nav-link" onclick="showSection('schedule')">
                <i class="fa-solid fa-calendar-alt"></i> Schedule
            </a>
            <a href="#appointments" class="nav-link" onclick="showSection('appointments')">
                <i class="fa-solid fa-calendar-check"></i> Appointments
            </a>



            <a href="logoutnow" class="nav-link text-danger" onclick="logout()">
                <i class="fa-solid fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">

        @yield('content')

    </div>



    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        Livewire.on('appointmentModal', () => {

            let modal = document.getElementById('modalappoint');
            var msg = new bootstrap.Modal(modal);
            msg.show();

        });

         Livewire.on('closenow', () => {

            let modal = document.getElementById('modalappoint');
            var msg = bootstrap.Modal.getInstance(modal);
            if(msg){
                msg.hide();
            }

        });

       


        
    </script>

</body>

</html>