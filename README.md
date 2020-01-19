### CTEC3110_COURSEWORK 
#### M2M Connect; SMS => PHP Processing

The application must, as a minimum:
- [x] Use a PHP SOAP client to download SMS messages from the M2M Connect server.
- [x] Parse all downloaded messages.
- [x] Validate all content.
- [x] Store the downloaded message (content and metadata) in the database.
- [x] Display the message content and metadata on the web-browser.
- [x] Message metadata: eg source SIM number, name, email address.
- [x] Message content: ie state of switches on the board, temperature, key-pad value.

A complete implementation will include the following methodologies and technologies that: have been discussed this academic year: 
- [x] Separation of Concerns Architecture & Single Point of Access
- [x] Object Oriented PHP
- [x] following the SOLID guidelines
- [x] SLIM micro-framework
- [x] TWIG template engine
- [x] Monolog logging
- [x] Application of security techniques and avoidance of common web application
vulnerabilities
- [x] Unit testing and security testing
- [x] Validated HTML 5 (using simple CSS for web-page layout/presentation)
- [x] MySQL/MariaDb
- [x] SOAP & WSDL file
- [x] Docblock comments
- [x] Consistent coding style
- [x] following the PHP-FIG PSR-1 & PSR-12 coding standards guidelines
- [x] Use of the Subversion Version Control Server
- [ ] Validation of all web-pages at http://validator.w3.org/ - include the W3C validated
logo on your web-pages when validated.

Possible extensions to the implementation could include:

- [x] implementation of registration and login/logout features, incorporating correct session
management. 
- [x] administration interface to maintain users/connection data in the database.
- [x] logging all web-application activity.
- [x] checking message metadata (eg name/phone number) against pre-stored values, thus
avoiding duplication of stored messages.
