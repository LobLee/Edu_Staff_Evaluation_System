<?php
    include('connection.php'); ?>


<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php include("Include/ad_sidebar.php");?>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="Assets/css/ad_dash.css">
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class = "Container">
<div class="header">
    <h1>Admin Dashboard</h1>
    </div>
<div class = "con1">

    <div class = "box">
        <a href = "ad_profile.php">
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
        <a href = "ad_task.php">
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
        <a href = "ad_evaluation.php">
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
    
    <div class = "box">
        <a href ="ad_staff.php">
            <div class = "title">
               Staff
            </div>
            <div class = "icon">
            <ion-icon name="person-outline"></ion-icon>
            </div>
            <div class = "description">
                Click here! to proceed into Staff
            </div>
        </a>
    </div>

</div>
<div class = "con2">

    <div class = "box">
        <a href = "ad_user_info.php">
            <div class = "title">
                User Info
            </div>
            <div class = "icon">
            <ion-icon name="person-circle-outline"></ion-icon>
            </div>
            <div class = "description">
                Click here! to proceed into User Info
            </div>
        </a>
    </div>
    
    <div class = "box">
        <a href ="ad_department.php">
            <div class = "title">
               Departments
            </div>
            <div class = "icon">
            <ion-icon name="school-outline"></ion-icon>
            </div>
            <div class = "description">
                Click here! to proceed into Departments
            </div>
        </a>
    </div>
   
</div>
</div> 
 <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

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