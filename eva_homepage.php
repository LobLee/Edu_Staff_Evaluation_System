<?php
    include('connection.php'); 
    function getProfileCount($conn) {
        $query = "SELECT COUNT(*) as count FROM profile";
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($result);
        return $data['count'];
    }
    function getTaskCount($conn) {
        $query = "SELECT COUNT(*) as count FROM eva_task";
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($result);
        return $data['count'];
    }
    function getEvaluationCount($conn) {
        $query = "SELECT COUNT(*) as count FROM evaluations";
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($result);
        return $data['count'];
    }

    // Usage
$profileCount = getProfileCount($conn);
$taskCount = getTaskCount($conn);
$evaluationCount = getEvaluationCount($conn);
?>


<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


 <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php include("Include/eva_sidebar.php");?>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="Assets/css/ad_dash.css">
<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="header">
    <h1>Evaluator Dashboard</h1>
    </div>
<div class = "con1">
    <div class = "box">
        <a href = "eva_profile.php">
            <div class = "title"><i class='bx bx-user icon'></i>
                Profile
            </div>       
            <div class = "description">
                Click here! to proceed into Profile
            </div>
            <div class="count">
                Total Profiles: <?php echo $profileCount; ?>
            </div>
        </a>
    </div>
    
    <div class = "box">
        <a href = "eva_task.php">
            <div class = "title"><ion-icon name="folder-open-outline"></ion-icon>
               Task
            </div>           
            <div class = "description">
                Click here! to proceed into Task
            </div>
            <div class="count">
                Total Task: <?php echo $taskCount; ?>
            </div>
        </a>
    </div>
      
</div>

<div class = "con2">

    <div class = "box">
        <a href = "eva_evaluation.php">
            <div class = "title"><ion-icon name="list-outline"></ion-icon>
                Evaluation
            </div>          
            <div class = "description">
                Click here! to proceed into Evaluation
            </div>
            <div class="count">
                Total Evaluation: <?php echo $evaluationCount; ?>
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