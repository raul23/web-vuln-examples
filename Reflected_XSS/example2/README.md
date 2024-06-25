# Reflected XSS - Example 2

## Overview

This example demonstrates a reflected XSS (Cross-Site Scripting) attack where user input is not properly sanitized before being reflected back to the user. An attacker can exploit this vulnerability by injecting malicious scripts into a URL parameter, which are then executed in the victim's browser.

## Vulnerable Scenario

### Attack Example

In the vulnerable example, a simple HTML page (`hello.php`) allows users to input their username via a URL parameter (`user`). The username is directly echoed back to the user without any validation or sanitization, making it vulnerable to a reflected XSS attack.

Here is the vulnerable code (`hello.php`):

```html
<!DOCTYPE html>
<html>
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
```

To test the reflected XSS attack, an attacker could use a URL like:

```
http://localhost:8000/hello.php?user=<script>alert('Reflected XSS attack!')</script>
```

This URL injects a `<script>` tag into the `user` parameter, which executes the JavaScript `alert()` function, displaying an alert box in the victim's browser.

## How to Simulate the Attack

### Steps to Reproduce

1. **Start a PHP Server**

   Use PHP to start a simple web server. Open a terminal and navigate to the directory containing `hello.php`, then run:

   ```sh
   php -S localhost:8000
   ```

   This will start a local PHP server on port 8000.

2. **Navigate to the Page with Normal Input**

   Open your browser and navigate to:

   ```
   http://localhost:8000/hello.php?user=Pedro
   ```

   You should see:

   ```
   Reflected XSS Example
   Hello, Pedro!
   ```

3. **Test the Reflected XSS Attack**

   Navigate to:

   ```
   http://localhost:8000/hello.php?user=%3Cscript%3Ealert(%22Reflected%20XSS%20attack!%22)%3C/script%3E
   ```

   You should see an alert box displaying `Reflected XSS attack!`.

## Why This is a Reflected XSS Attack

Reflected XSS attacks occur when user input is not properly sanitized or validated before being echoed back to the user in the application's response. In this example, the `user` parameter from the URL is directly embedded into the HTML without any escaping or filtering. This allows an attacker to craft a URL that injects and executes arbitrary JavaScript code in the context of the victim's browser session.

By understanding and testing this vulnerability, developers can implement proper input validation and sanitization techniques to mitigate the risk of XSS attacks in their web applications. Always sanitize and validate user input to prevent such vulnerabilities from being exploited.

## Source

This example is based on the scenario provided in the article: [XSS101 - Understanding Cross Site Scripting](https://brutelogic.com.br/blog/xss101/)
