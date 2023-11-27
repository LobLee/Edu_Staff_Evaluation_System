
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: row;
        }

        main {
            flex: 1;
        }

        .navbar {
            flex: 0 0 auto;
        }

        .sidebar {
            flex: 0 0 250px;
            background-color: #f8f9fa;
            padding: 20px;
            height: 100%;
        }
    </style>
    <title>Edu Staff Evaluation System</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-3 m-0 border-0 bd-example m-0 border-0 d-flex">
    
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Edu Staff Evaluation System</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Dashboard</a>
            </li>

            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Task
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>     
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Staff
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>     
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">Departments</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    User Info
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>     
                </ul>
            </li>

            <li>
                    <a href="index.php">
                        <span class="icon"><i class="las la-sign-out-alt"></i></span>
                        <span class="title">Sign-out</span>
                    </a>
                </li>
        </ul>
    </div>
    <!-- End Sidebar -->

    <!-- Main Content -->
    <main class="p-3">
        <!-- Your main content goes here -->
        <h1>Main Content</h1>
    </main>
    <!-- End Main Content -->
</body>
</html>
