# Web Vulnerability Examples

Welcome to the Web Vulnerability Examples repository! This project provides example code for various web vulnerabilities, including stored, reflected, and DOM-based XSS attacks, along with their mitigation strategies.

## Table of Contents

- [Introduction](#introduction)
- [Vulnerabilities](#vulnerabilities)
  - [Stored XSS](#stored-xss)
  - [Reflected XSS](#reflected-xss)
  - [DOM-Based XSS](#dom-based-xss)
- [Contributing](#contributing)
- [License](#license)

## Introduction

This repository aims to educate developers about common web vulnerabilities and how to mitigate them. Each vulnerability type contains multiple examples with accompanying explanations.

## Vulnerabilities

### Stored XSS
- [Example 1](Stored_XSS/example1)
- [Example 2](Stored_XSS/example2)

### Reflected XSS
- [Example 1](Reflected_XSS/example1)

### DOM-Based XSS
- **[Example 1](DOM_Based_XSS/example1)**: 
  A simple HTML page allows the user to select their preferred language via a dropdown menu. The default language can be set using a query parameter in the URL. This parameter is processed and written into the DOM, making it vulnerable to a DOM-based XSS attack. It uses `document.write`.
  
  - **Mitigation Examples**:
    - [Mitigation 1](DOM_Based_XSS/example1/mitigation/example1-1): Uses `textContent` instead of `document.write` to update the DOM safely.
    - [Mitigation 2](DOM_Based_XSS/example1/mitigation/example1-2): Uses the `setAttribute` method to safely set the value attribute of an element, mitigating the DOM-based XSS attack.
    - [Mitigation 3](DOM_Based_XSS/example1/mitigation/example1-3): Uses DOMPurify to sanitize input, ensuring that any potentially harmful scripts are removed before being inserted into the DOM.

## Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
