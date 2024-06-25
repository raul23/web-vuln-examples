# Reflected XSS - Example 2

## Overview

This example demonstrates a reflected XSS (Cross-Site Scripting) attack where user input is not properly sanitized before being reflected back to the user. An attacker can exploit this vulnerability by injecting malicious scripts into a form input field, which are then executed in the victim's browser.

## Vulnerable Scenario

### Attack Example

In this example, a simple HTML page (`index.html`) contains a form that allows users to search for a query. The search query is sent to a PHP script (`search.php`) via a GET request. The PHP script then echoes the query back to the user without any validation or sanitization, making it vulnerable to a reflected XSS attack.

Here is the vulnerable code:

#### `index.html`

```html
<!DOCTYPE html>
<html>
<head>
    <title>Search Page</title>
</head>
<body>
    <form action="search.php" method="GET">
        <input type="text" name="query">
        <input type="submit" value="Search">
    </form>
</body>
</html>
```

#### `search.php`

```php
<?php
  $query = $_GET['query'];
  echo "You searched for: " . $query;
?>
```

To test the reflected XSS attack, an attacker could input a search query like:

```
<script>alert('Reflected XSS attack!')</script>
```

This input injects a `<script>` tag into the `query` parameter, which executes the JavaScript `alert()` function, displaying an alert box in the victim's browser.

## How to Simulate the Attack

### Steps to Reproduce

1. **Start a PHP Server**

   Use PHP to start a simple web server. Open a terminal and navigate to the directory containing `index.html` and `search.php`, then run:

   ```sh
   php -S localhost:8000
   ```

   This will start a local PHP server on port 8000.

2. **Navigate to the Page and Perform a Normal Search**

   Open your browser and navigate to:

   ```
   http://localhost:8000
   ```

   Enter `test` in the search box and click "Search". You should see:

   ```
   You searched for: test
   ```

3. **Test the Reflected XSS Attack**

   Enter the following in the search box:

   ```
   <script>alert("Reflected XSS attack!")</script>
   ```

   Click "Search" and you should see an alert box displaying `Reflected XSS attack!`.

## Why This is a Reflected XSS Attack

Reflected XSS attacks occur when user input is not properly sanitized or validated before being echoed back to the user in the application's response. In this example, the `query` parameter from the form input is directly embedded into the HTML without any escaping or filtering. This allows an attacker to craft input that injects and executes arbitrary JavaScript code in the context of the victim's browser session.

By understanding and testing this vulnerability, developers can implement proper input validation and sanitization techniques to mitigate the risk of XSS attacks in their web applications. Always sanitize and validate user input to prevent such vulnerabilities from being exploited.
