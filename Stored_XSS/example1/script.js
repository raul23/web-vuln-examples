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
