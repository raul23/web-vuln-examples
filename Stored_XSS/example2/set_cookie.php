<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    setcookie("myname", $name, time() + 3600, "/"); // Set cookie for 1 hour
    echo "Cookie set. Go to <a href='message_board.php'>message board</a>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set Cookie</title>
</head>
<body>
    <h1>Set Cookie</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Enter your name (or malicious script):</label>
        <input type="text" id="name" name="name" required><br><br>
        <button type="submit">Set Cookie</button>
    </form>
</body>
</html>
