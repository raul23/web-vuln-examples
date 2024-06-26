# DOM-Based XSS - Example 1

This repository is part of the `web-vuln-examples` project, showcasing various web vulnerabilities and their mitigation strategies. This example demonstrates a DOM-based XSS attack, based on an example provided by the [OWASP article on DOM-based XSS](https://owasp.org/www-community/attacks/DOM_Based_XSS).

## Description

In this example, a simple HTML page allows the user to select their preferred language via a dropdown menu. The default language can be set using a query parameter in the URL. This parameter is processed and written into the DOM, making it vulnerable to a DOM-based XSS attack.

## Files

### `index.html`

This HTML file contains the vulnerable code:

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

## Running the Example

### Using PHP Server

1. **Start the PHP Server**

   Open a terminal, navigate to the directory containing `index.html`, and run:

   ```sh
   php -S localhost:8000
   ```

2. **Test with Normal Input**

   Open your browser and navigate to:

   ```
   http://localhost:8000/?default=French
   ```

   You should see "French" as an option in the dropdown.

3. **Test with Malicious Input**

   To demonstrate the DOM-based XSS attack, navigate to:

   ```
   http://localhost:8000/index.html?default=<script>alert("DOM-based XSS attack!")</script>
   ```

   This should trigger a JavaScript alert displaying "DOM-based XSS attack!".

### Using Python Server

1. **Start a Simple HTTP Server**

   Open a terminal, navigate to the directory containing `index.html`, and run:

   ```sh
   python3 -m http.server 8000
   ```

2. **Test with Normal Input**

   Open your browser and navigate to:

   ```
   http://localhost:8000/index.html?default=French
   ```

   You should see "French" as an option in the dropdown.

3. **Test with Malicious Input**

   To demonstrate the DOM-based XSS attack, navigate to:

   ```
   http://localhost:8000/index.html?default=<script>alert("DOM-based XSS attack!")</script>
   ```

   This should trigger a JavaScript alert displaying "DOM-based XSS attack!".

## Why This is a DOM-based XSS Attack

This example is a DOM-based XSS attack because the payload is processed and executed entirely on the client side. The JavaScript code on the page dynamically writes content into the DOM using `document.write` based on the URL parameter. Since the `default` parameter is not properly sanitized, it can contain malicious code that gets executed when the page is rendered. The attack vector lies within the DOM manipulation performed by the client's browser, highlighting the importance of secure client-side scripting practices.

## Mitigation Examples

- [Mitigation 1](mitigation/example1-1): Uses `textContent` instead of `document.write` to update the DOM safely.
- [Mitigation 2](mitigation/example1-2): Uses DOMPurify to sanitize input, ensuring that any potentially harmful scripts are removed before being inserted into the DOM.

## Important Considerations

- **Security Risk**: This example intentionally exposes a vulnerability for educational purposes. In a real-world scenario, always sanitize and validate user input to prevent XSS attacks.
- **Mitigation**: Use appropriate encoding and validation techniques to prevent execution of untrusted data. For example, avoid using `document.write` with untrusted data. Use `textContent` or other safer methods to manipulate the DOM.

By following these steps, you can demonstrate a DOM-based XSS attack and understand how such vulnerabilities can be exploited and prevented. If you have any more questions or need further assistance, feel free to ask!
