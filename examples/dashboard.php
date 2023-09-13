<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
//Loading Autoload file 
require '../vendor/autoload.php'; 

use Organogram\employee;

// Check if the user is logged in
if (!isset($_SESSION['employee_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: index.php");
    exit;
}

$employee = new Employee();

// Retrieve user information from the session
$employeeId = $_SESSION['employee_id'];
$email = $_SESSION['email'];
$departmentId = $_SESSION['department_id'];


$underMeEmployees = $employee->getEmployeeUnerMe($employeeId, $departmentId);
// var_dump($underMeEmployees);

// Handle logout
if (isset($_POST['logout'])) {
    // Destroy the session and redirect to the login page
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>
        /* Define some basic CSS styles for the hierarchy */
        .org-chart {
            list-style-type: none;
        }

        .org-chart li {
            display: inline-block;
            margin: 10px;
        }
        p{
            margin: 0;
        }
        
    </style>
</head>
<body>
    <h2>Welcome to Dashboard, <?php echo htmlspecialchars($email); ?>!</h2>


    <h3>Employees Under Me:</h3>
    <ul class="org-chart">
        <?php foreach ($underMeEmployees['employees'] as $employee): ?>
            <li>
                <p> <strong>Name:</strong> <?php echo $employee['employee_name']; ?></p>
                <p> <strong>Email:</strong> <?php echo $employee['email']; ?></p>
                <p> <strong>Role:</strong> <?php echo $employee['role_name']; ?></p>
                <p> <strong>Department:</strong> <?php echo $employee['department_name']; ?></p>
            </li>
        <?php endforeach; ?>
    </ul>

    <hr>
    
    <!-- logout -->
    <a href="logout.php">Logout</a>
</body>
</html>
