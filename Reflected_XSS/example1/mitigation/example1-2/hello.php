<!DOCTYPE html>
<html>
<meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'">
<head>
    <title>Reflected XSS Example</title> 
</head>
<body>
    <h1>Reflected XSS Example</h1>
    
    <?php
    // Retrieve username from URL parameter
    $username = $_GET['user'];
    ?>

    <h2>Hello, <?php echo $username; ?>!</h2>
</body>
</html>
