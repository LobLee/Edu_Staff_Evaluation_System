<?php
include("connection.php");

class Task {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getTasks() {
        $query = "SELECT * FROM eva_task";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $tasks = [];
            while ($row = $result->fetch_assoc()) {
                $tasks[] = $row;
            }
            return $tasks;
        } else {
            return [];
        }
    }

    public function addTask($type, $due_date, $assigned_to, $status, $actions) {
        $type = $this->conn->real_escape_string($type);
        $due_date = $this->conn->real_escape_string($due_date);
        $assigned_to = $this->conn->real_escape_string($assigned_to);
        $status = $this->conn->real_escape_string($status);
        $actions = $this->conn->real_escape_string($actions);

        $query = "INSERT INTO eva_task(task, due_date, assigned_to, status, actions) VALUES ('$type', '$due_date', '$assigned_to', '$status', '$actions')";
        $result = $this->conn->query($query);

        return $result;
    }

    // Inside the Task class
    public function getTaskDetails($taskId) {
    $taskId = $this->conn->real_escape_string($taskId);
    $query = "SELECT * FROM eva_task WHERE id = $taskId";
    $result = $this->conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

}

$task = new Task($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['task'];
    $due_date = $_POST['due_date'];
    $assigned_to = $_POST['assigned_to'];
    $status = $_POST['status'];
    $actions = $_POST['actions'];

    $result = $task->addTask($type, $due_date, $assigned_to, $status, $actions);

    if ($result) {
        echo "Task added successfully";
    } else {
        echo "Error adding task: " . $conn->error;
    }
}

$tasks = $task->getTasks();
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php include("Include/eva_sidebar.php");?>

    <title>Edu Staff Evaluation System</title>
    <link rel="stylesheet" href="Assets/css/eva_task.css">
</head>
<body>
    <div class="Container">
    <div class="header">
        <header>Task List</header>
        <?php if (!empty($tasks)) : ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Task</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Assigned To</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($tasks as $index => $task) : ?>
                        <tr>
                            <th scope="row"><?= $index + 1 ?></th>
                            <td><?= $task['task'] ?></td>
                            <td><?= $task['due_date'] ?></td>
                            <td><?= $task['assigned_to'] ?></td>
                            <td><?= $task['status'] ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="" data-toggle="modal" data-target="#viewTaskModal<?= $index ?>">View Task</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#viewProgressModal<?= $index ?>">View Progress</a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                                
                    <!-- View Task Modal -->
                    <div class="modal fade" id="viewTaskModal<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel<?= $index ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewTaskModalLabel<?= $index ?>">View Task</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="modal-body-content">
                                    <p><strong>Task:</strong> <?= $task['task'] ?></p>
                                    <p><strong>Due Date:</strong> <?= $task['due_date'] ?></p>
                                    <p><strong>Assigned To:</strong> <?= $task['assigned_to'] ?></p>
                                    <p><strong>Status:</strong> <?= $task['status'] ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                        <!-- View Progress Modal -->
                        <div class="modal fade" id="viewProgressModal<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="viewProgressModalLabel<?= $index ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewProgressModalLabel<?= $index ?>">View Progress</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add content to display progress details here -->
                                        Progress details for Task #<?= $index + 1 ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <tr>
                <td colspan="5">No tasks found..</td>
            </tr>       
        <?php endif; ?>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
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
<?php
//close the database
    mysqli_close($conn);
?>