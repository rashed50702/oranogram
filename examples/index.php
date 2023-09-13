<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['employee_id'])) {
    // Redirect to the dashboard or authorized page
    header("Location: dashboard.php"); // Replace with your dashboard page
    exit;
}

// Rest of your index.php code (login form) goes here
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<style type="text/css" media="screen">
    input, select {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input[type=submit] {
      width: 100%;
      background-color: #4CAF50;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type=submit]:hover {
      background-color: #45a049;
    }

    .container{
        padding: 100px;
    }
    .content{
        max-width: 600px;
        margin: auto;
        width: 50%;
        border: 3px solid green;
        padding: 10px;
    }
    .text-center{
        text-align: center;
    }
    .error-message{
        color: darkred;
        font-weight: bold;
    }
</style>
<body>
    <div class="container">
        <div class="content">
            <?php
            if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($_SESSION['error']); ?>        
                </div>
                <?php unset($_SESSION['error']); // Remove the error message from the session ?>
            <?php endif; ?>

            <h2 class="text-center">Login</h2>
            <form action="login.php" method="post">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" required value="AlanPBlane@jourrapide.com"><br>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required value="123456"><br>

                <label for="department">Department:</label>
                <select name="department" id="department" required>
                    <option value="">Select Department</option>
                </select><br>

                <input type="submit" value="Login">
            </form>
        </div>
    </div>


    <script>
        // JavaScript to populate the department dropdown
        const departmentDropdown = document.getElementById("department");

        // Fetch department data from departments.php
        fetch("departments.php")
            .then(response => response.json())
            .then(data => {
                // Populate the dropdown options
                data.forEach(department => {
                    const option = document.createElement("option");
                    option.value = department.id;
                    option.textContent = department.name;
                    departmentDropdown.appendChild(option);
                });
            })
            .catch(error => console.error(error));

    </script>
</body>
</html>