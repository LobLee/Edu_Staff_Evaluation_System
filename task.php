<?php
    include('connection.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<?php  include("Include/eva_sidebar.php");?>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="Assets/css/ad_dash.css">
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

<div class = "con1">
    <div class = "box">
        <a href = "eva_profile.php">
            <div class = "title">
                Profile
            </div>
            <div class = "icon">
                <i class='bx bx-user icon'></i>
            </div>
            <div class = "description">
                Click here! to proceed into Profile
            </div>
        </a>
    </div>
    
    <div class = "box">
        <a href = "eva_task.php">
            <div class = "title">
               Task
            </div>
            <div class = "icon">
            <ion-icon name="folder-open-outline"></ion-icon>
            </div>
            <div class = "description">
                Click here! to proceed into Task
            </div>
        </a>
    </div>
      
</div>

<div class = "con2">

    <div class = "box">
        <a href = "eva_evaluation.php">
            <div class = "title">
                Evaluation
            </div>
            <div class = "icon">
            <ion-icon name="list-outline"></ion-icon>
            </div>
            <div class = "description">
                Click here! to proceed into Evaluation
            </div>
        </a>
    </div>

</div>    
</div>
    
</script>
<script>
        //Menu Toggle
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