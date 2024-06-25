# Stored XSS - Example 1

## Overview

This example demonstrates a stored XSS (Cross-Site Scripting) attack where malicious scripts are stored on the server and executed in the browser when the affected data is requested. This type of attack is more persistent and dangerous than reflected XSS, as it can impact multiple users.

## Vulnerable Scenario

### Attack Example

In this example, a simple user creation page (`CreateUser.php`) allows users to input their details. The user details are saved to a text file. Another page (`ListUsers.php`) retrieves and displays these user details without proper sanitization, making it vulnerable to a stored XSS attack.

### `CreateUser.php`

This PHP script processes the user input and saves it to a text file.

```html
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
```

### `ListUsers.php`

This PHP script retrieves the user data from the text file and displays it.

```html
<!DOCTYPE html>
<html>
<head>
    <title>List Users</title>
</head>
<body>
    <h1>List of Active Users</h1>

    <div id="userlist">
        Currently Active Users:
        <?php
        // Read user data from text file
        $users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($users === false) {
            exit('Error reading user data.');
        }

        // Print list of users to page
        foreach ($users as $user) {
            list($username, $password, $fullName) = explode(',', $user);
            echo '<div class="userNames">' . $fullName . '</div>'; // No htmlspecialchars() used intentionally
        }
        ?>
    </div>

</body>
</html>
```

## How to Simulate the Attack

### Steps to Reproduce

1. **Start a PHP Server**

   Use PHP to start a simple web server. Open a terminal and navigate to the directory containing `CreateUser.php` and `ListUsers.php`, then run:

   ```sh
   php -S localhost:8000
   ```

   This will start a local PHP server on port 8000.

2. **Create a Normal User**

   Open your browser and navigate to:

   ```
   http://localhost:8000/CreateUser.php
   ```

   Fill the form fields with:
   - Username: `testusername`
   - Password: `pass12345`
   - Full Name: `John Doe`

   Click on the "Create User" button. You should see the message `User created successfully!` and a file `users.txt` is created.

3. **View the List of Users**

   Navigate to:

   ```
   http://localhost:8000/ListUsers.php
   ```

   You should see the full name of the created user displayed.

4. **Perform the Stored XSS Attack**

   Navigate back to:

   ```
   http://localhost:8000/CreateUser.php
   ```

   Fill the form fields with:
   - Username: `malicioususer`
   - Password: `pass12345`
   - Full Name: `<script>alert("Stored XSS attack!")</script>`

   Click on the "Create User" button. You should see the message `User created successfully!`.

5. **Trigger the Stored XSS Attack**

   Navigate to:

   ```
   http://localhost:8000/ListUsers.php
   ```

   You should see an alert box displaying `Stored XSS attack!`.

## Why This is a Stored XSS Attack

Stored XSS attacks occur when user input is stored on the server and later included in the web page without proper sanitization or escaping. In this example, the `fullName` parameter from the user input is directly saved to a text file and later displayed in the `ListUsers.php` page without any escaping or filtering. This allows an attacker to inject and execute arbitrary JavaScript code whenever the affected data is viewed by any user.

By understanding and testing this vulnerability, developers can implement proper input validation and sanitization techniques to mitigate the risk of XSS attacks in their web applications. Always sanitize and validate user input to prevent such vulnerabilities from being exploited.

## Source

This example is based on example 4 provided in the article [CWE-79: Improper Neutralization of Input During Web Page Generation ('Cross-site Scripting')](https://cwe.mitre.org/data/definitions/79.html).
