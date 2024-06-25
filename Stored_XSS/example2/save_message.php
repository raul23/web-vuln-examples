<?php
function saveMessage($message) {
    $file = 'messages.txt';
    file_put_contents($file, $message . PHP_EOL, FILE_APPEND | LOCK_EX);
}

if (isset($_COOKIE["myname"])) {
    $name = $_COOKIE["myname"];
    $announceStr = "$name just logged in.";
    saveMessage($announceStr);
    header("Location: message_board.php"); // Redirect to message board
    exit;
} else {
    echo "No name cookie set. Go to <a href='set_cookie.php'>set cookie</a>";
}
?>
