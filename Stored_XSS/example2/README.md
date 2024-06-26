# Stored XSS - Example 2

## Overview

This example demonstrates a stored XSS (Cross-Site Scripting) attack where user input is stored in a cookie and later displayed on a message board without proper sanitization. This stored XSS vulnerability allows malicious scripts to be executed in the browser whenever the affected data is viewed.

## Vulnerable Scenario

### Attack Example

In this example, a PHP script (`set_cookie.php`) allows users to input their name, which is then stored in a cookie. Another script (`save_message.php`) retrieves the cookie value and stores it in a text file as a message. The messages are displayed on a message board (`message_board.php`) without proper sanitization, making it vulnerable to stored XSS attacks.

### `set_cookie.php`

This PHP script sets a cookie with the user's input.

```php
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
```

### `save_message.php`

This PHP script retrieves the cookie value and saves it as a message in a text file.

```php
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
```

### `message_board.php`

This PHP script reads the messages from the text file and displays them.

```html
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
```

## How to Simulate the Attack

### Steps to Reproduce

1. **Start a PHP Server**

   Use PHP to start a simple web server. Open a terminal and navigate to the directory containing `set_cookie.php`, `save_message.php`, and `message_board.php`, then run:

   ```sh
   php -S localhost:8000
   ```

   This will start a local PHP server on port 8000.

2. **Create a Normal Cookie**

   Open your browser and navigate to:

   ```
   http://localhost:8000/set_cookie.php
   ```

   Enter the name `John Doe` in the input field and click on the "Set Cookie" button. You should see the message `Cookie set. Go to message board`.

3. **Save a Normal Message**

   Navigate to:

   ```
   http://localhost:8000/save_message.php
   ```

   You should be redirected to:

   ```
   http://localhost:8000/message_board.php
   ```

   You should see the message `John Doe just logged in.` displayed, and a file `messages.txt` is created.

4. **Perform the Stored XSS Attack**

   Navigate back to:

   ```
   http://localhost:8000/set_cookie.php
   ```

   Enter the following in the input field: `<script>alert("Stored XSS attack!")</script>`

   Click on the "Set Cookie" button. You should see the message `Cookie set. Go to message board`.

5. **Trigger the Stored XSS Attack**

   Navigate to:

   ```
   http://localhost:8000/save_message.php
   ```

   You should be redirected to:

   ```
   http://localhost:8000/message_board.php
   ```

   An alert box displaying `Stored XSS attack!` should appear, indicating that the stored XSS attack was successful.

## Why This is a Stored XSS Attack

Stored XSS attacks occur when user input is stored on the server and later included in the web page without proper sanitization or escaping. In this example, the `name` parameter from the user input is stored in a cookie and later saved to a text file as a message. The messages are displayed in the `message_board.php` page without any escaping or filtering, allowing an attacker to inject and execute arbitrary JavaScript code whenever the affected data is viewed.

By understanding and testing this vulnerability, developers can implement proper input validation and sanitization techniques to mitigate the risk of XSS attacks in their web applications. Always sanitize and validate user input to prevent such vulnerabilities from being exploited.

## Source

This example is based on example 5 provided in the article [CWE-79: Improper Neutralization of Input During Web Page Generation ('Cross-site Scripting')](https://cwe.mitre.org/data/definitions/79.html).
