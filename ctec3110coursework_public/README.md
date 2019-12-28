# CTEC3110_COURSEWORK
M2M Connect; SMS => PHP Processing

The application must, as a minimum:
- Use a PHP SOAP client to download SMS messages from the M2M Connect server. **(done)**
- Parse all downloaded messages. **(partially done)**
- Validate all content.
- Store the downloaded message (content and metadata) in the database.
- Display the message content and metadata on the web-browser **(partially done)**
- Message metadata:
- - eg source SIM number, name, email address 
- Message content:
- - ie state of switches on the board, temperature, key-pad value, etc

A complete implementation will include the following methodologies and technologies that: have been discussed this academic year: 
- Separation of Concerns Architecture & Single Point of Access
- Object Oriented PHP
- following the SOLID guidelines
- SLIM micro-framework
- TWIG template engine
- Monolog logging
-  Application of security techniques and avoidance of common web application
vulnerabilities
- Unit testing and security testing
- Validated HTML 5 (using simple CSS for web-page layout/presentation)
- MySQL/MariaDb
- SOAP & WSDL file
- Docblock comments
- Consistent coding style
- following the PHP-FIG PSR-1 & PSR-12 coding standards guidelines
- Use of the Subversion Version Control Server
- Validation of all web-pages at http://validator.w3.org/ - include the W3C validated
logo on your web-pages when validated.

Possible extensions to the implementation could include:

- implementation of registration and login/logout features, incorporating correct session
management.
- displaying numerical data in chart form.
- an interface to send SMS messages back to the “circuit board” containing updated
settings for the board.
- administration interface to maintain users/connection data in the database.
- logging all web-application activity.
- using AJAX and JSON (or an RSS/ATOM feed) to update the display in the browser
as new SMS reports are downloaded.
- checking message metadata (eg name/phone number) against pre-stored values, thus
avoiding duplication of stored messages.
- sending an SMS or email reporting the receipt of the new message to the user’s
connection details.