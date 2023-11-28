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
                <li>
                    <a href="EduStaff Evaluate System">
                        <span class="icon"><i class="las la-school"></i></span>
                        <span class="title">EduStaff <br> Evaluator</span>
                    </a>
                </li>
               
                <li>
                    <a href="eva_homepage.php">
                        <span class="icon"><i class="las la-desktop"></i></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="eva_task.php">
                        <span class="icon"><i class="las la-tasks"></i></span>
                        <span class="title">Task</span>
                    </a>
                </li>
                <li>
                    <a href="eva_evaluation.php">
                       <ion-icon name="person-outline"></ion-icon>
                        <span class="title">Evaluation</span>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <span class="icon"><i class="las la-sign-out-alt"></i></span>
                        <span class="title">Sign-out</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <?php include("Include/manage_account.php");?>
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
