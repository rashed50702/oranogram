<?php
//Loading Autoload file 
require '../vendor/autoload.php'; 

use Organogram\department;

// Create an instance of the Department class
$departmentModel = new Department();

// Get department data
$data = $departmentModel->getDepartments();

// Return department data as JSON
header('Content-Type: application/json');
echo json_encode($data);