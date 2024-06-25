<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
</head>
<body>
    <h1>Create User</h1>

    <?php
    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user inputs
        $username = $_POST['username'];
        $password = crypt($_POST['password']); // Encrypt password (just an example)
        $fullName = $_POST['fullName'];

        // Validate input (you can add more validation as needed)

        // Save user data to a text file
        $userRecord = "$username,$password,$fullName" . PHP_EOL; // Each user on a new line
        file_put_contents('users.txt', $userRecord, FILE_APPEND | LOCK_EX); // Append to file

        echo "<p>User created successfully!</p>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required><br><br>
        <button type="submit">Create User</button>
    </form>

</body>
</html>
