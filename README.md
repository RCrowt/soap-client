# Guzzle inspired PHP Soap Client

## Request
Extend the request class for the soap function you want to call. The SOAP request body can be built from an array of data just like standard PHP SOAP client does. Alternatively it can be built from a Laravel view.

- Quicker to build requests which have lots of default values or complex structures.
- Usefull where the SOAP message is actually XML wrapped in a SOAP body.

## Middleware
The Laravel inspired middleware allows requests/responses to be read/modified. 

- Excellent for loggging request/response XML.
- Allows errors which aren't throwing SOAP faults to be caught and handled better.

## Response
The response class should be extneded to implement any intefaces your code may be expecting.

- Request/response XML accessible from the response object for easier debugging.
- Access the request object and data from the response.
