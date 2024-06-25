<!DOCTYPE html>
<html>
<head>
    <title>Message Board</title>
</head>
<body>
    <h1>Message Board</h1>
    <div id="messages">
        <?php
        $file = 'messages.txt';
        if (file_exists($file)) {
            $messages = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($messages as $message) {
                echo "<div class='message'>$message</div>";
            }
        } else {
            echo "No messages yet.";
        }
        ?>
    </div>
</body>
</html>
