<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
//Loading Autoload file 
require '../vendor/autoload.php'; 

use Organogram\employee;

// Create an instance of the Employee class
$employee = new Employee();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $departmentId = $_POST['department'];

    

    // Use the `loginEmployee` method to perform the login logic
    $loggedInEmployee = $employee->loginEmployee($email, $password, $departmentId);

    if ($loggedInEmployee) {
        // Set session variables if login is successful
        $_SESSION['employee_id'] = $loggedInEmployee['id'];
        $_SESSION['email'] = $loggedInEmployee['email'];
        $_SESSION['department_id'] = $loggedInEmployee['department_id'];

        // Redirect to the dashboard or home page
        header("Location: dashboard.php"); // Replace with your dashboard page
        exit;
    } else {
        // Invalid login, store the error message in a session variable
        $error = "Invalid email, password, or department.";
        $_SESSION['error'] = $error;
        header("Location: index.php");
        exit;
    }
}
?>
