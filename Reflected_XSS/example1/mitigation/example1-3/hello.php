<!DOCTYPE html>
<html>
<head>
    <title>Reflected XSS Example</title>
</head>
<body>
    <h1>Reflected XSS Example</h1>
    
    <?php
    // Retrieve and sanitize username from URL parameter
    $username = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
    ?>

    <h2>Hello, <?php echo $username; ?>!</h2>
</body>
</html>
