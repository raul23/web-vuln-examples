# DOM-Based XSS Mitigation 2

## Overview

This example demonstrates how to mitigate a DOM-based XSS attack by using the `setAttribute` method instead of directly writing to the DOM. The original vulnerability allowed an attacker to inject malicious scripts via a URL parameter, but this mitigation ensures that any injected content is treated as plain text, preventing the execution of harmful scripts.

## Vulnerable Scenario

### Attack Example

In the original vulnerable example, a simple HTML page allowed the user to select their preferred language via a dropdown menu. The default language could be set using a query parameter in the URL. This parameter was processed and written into the DOM using `document.write`, making it susceptible to a DOM-based XSS attack.

Here is the original code:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Language Selection</title>
</head>
<body>
    <h1>Select your language:</h1>
    <select>
        <script>
            const urlParams = new URLSearchParams(window.location.search);
            const defaultLang = urlParams.get('default');
            if (defaultLang) {
                document.write("<option value='1'>" + decodeURIComponent(defaultLang) + "</option>");
            }
            document.write("<option value='2'>English</option>");
        </script>
    </select>
</body>
</html>
```

To test the DOM-based XSS attack, an attacker could use a URL like:

```
http://localhost:8000/?default=<script>alert('DOM-based XSS attack!')</script>
```

This would inject the script into the page, displaying an alert box.

## Mitigation Example

### Using `setAttribute` to Prevent XSS

By using `setAttribute` and `textContent`, we can ensure that any injected content is treated as plain text, preventing the execution of malicious scripts.

Here is the mitigated version of the code:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Language Selection</title>
</head>
<body>
    <h1>Select your language:</h1>
    <select id="languageSelect">
        <option value="2">English</option>
    </select>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const defaultLang = urlParams.get('default');
        if (defaultLang) {
            const option = document.createElement("option");
            option.setAttribute("value", "1");
            option.textContent = decodeURIComponent(defaultLang);
            document.getElementById("languageSelect").appendChild(option);
        }
    </script>
</body>
</html>
```

### How to Test the Mitigation

1. **Start a Simple HTTP Server**

   Use Python to start a simple HTTP server. Open a terminal and navigate to the directory containing `index.html`, then run:

   ```sh
   python3 -m http.server 8000
   ```

   This will start a local web server on port 8000.

2. **Invoke the Page with a Normal Query**

   Open your browser and navigate to:

   ```
   http://localhost:8000/index.html?default=French
   ```

   You should see "French" as an option in the dropdown.

3. **Invoke the Page with a Malicious Query**

   Now, test the mitigation by navigating to:

   ```
   http://localhost:8000/index.html?default=<script>alert('DOM-based XSS attack!')</script>
   ```

   You should not see an alert box. Instead, the dropdown will display the literal text `<script>alert('DOM-based XSS attack!')</script>` as a selectable option, demonstrating that the script was not executed.

## Why This is a DOM-Based XSS Attack

DOM-based XSS attacks occur when the vulnerability exists in the client-side code that processes and dynamically inserts user input into the DOM. In this example, the vulnerability is due to the use of `document.write` to insert a parameter from the URL directly into the page's HTML, allowing an attacker to inject and execute malicious scripts. By using `setAttribute` and `textContent`, we mitigate this risk by ensuring that any user input is treated as plain text, not executable code.

