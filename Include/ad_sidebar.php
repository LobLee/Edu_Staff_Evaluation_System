
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edustaff Evaluate System</title>
    <link rel="stylesheet" href="Assets/css/new.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Nosifer&family=Playfair+Display&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Navigation -->
            <div class="col-md-3">
                <div class="navigation">
                    <div class="toggle">
                        <span class="las la-bars"></span>
                    </div>
                    <ul>
                        <!-- ... your navigation items ... -->
                        <li>
                    
                        <span class="icon"><i class="las la-school"></i></span>
                        <span class="title">EduStaff <br> Evaluation System</span>
                    
                </li>
                
                <li>
                    <a href="admin.php">
                        <span class="icon"><i class="las la-desktop"></i></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="ad_task.php">
                        <span class="icon"><i class="las la-tasks"></i></span>
                        <span class="title">Task</span>
                    </a>
                </li>

                <li>
                    <a href="ad_evaluation.php">
                    <span class="icon"><i class="list-outline"></i></span>
                        <span class="title">Evaluation</span>
                    </a>
                </li>
                
                <li>
                    <a href="ad_staff.php">
                    <span class="icon"><i class ="person-outline"></i></span>
                        <span class="title">Staff</span>
                    </a>
                </li>
                <li>
                    <a href="ad_user_info.php">
                        <span class="icon"><i class="las la-users"></i></span>
                        <span class="title">User Info</span>
                    </a>
                </li>
                
                <li>
                    <a href="ad_department.php">
                        <span class="icon"><i class="las la-building"></i></span>
                        <span class="title">Departments</span>
                    </a>
                </li>

                <li>
                    <a href="manage_account.php">
                        <span class="icon"><i class="las la-cog"></i>
                        <span class="title">Manage Account</span>
                    </a>
                </li>

                <li>
                    <a href="index.php">
                        <span class="icon"><i class="las la-sign-out-alt"></i></span>
                        <span class="title">Logout</span>
                    </a>
                </li>

                </ul>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
   <div class="main">
        <div class="topbar">
            <div class="h2">
                <h2>Edu Staff Evaluation System</h2>
            </div>
        </div>
    </div>
    <script>
         // Menu Toggle
         let toggle = document.querySelector('.toggle');
        let navigation = document.querySelector('.navigation');
        let main = document.querySelector('.main');

        toggle.onclick = function(){
            navigation.classList.toggle('active')
            main.classList.toggle('active')
        }
    </script>
</body>
</html>
