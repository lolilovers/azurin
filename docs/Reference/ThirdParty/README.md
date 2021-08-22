# Third Party Developer Tool

This tool is based on composer installation of kint-php/kint and filp/whoops.

Kint and Whoops only activated when in development mode

# Kint

At first glance Kint is just a pretty replacement for var_dump(), print_r() and debug_backtrace().

However, it's much, much more than that. You will eventually wonder how you developed without it.


```php
<?php

Kint::dump($GLOBALS, $_SERVER); // pass any number of parameters
d($GLOBALS, $_SERVER); // or simply use d() as a shorthand

Kint::trace(); // Debug backtrace
d(1); // Debug backtrace shorthand

s($GLOBALS); // Basic output mode

~d($GLOBALS); // Text only output mode

Kint::$enabled_mode = false; // Disable kint
d('Get off my lawn!'); // Debugs no longer have any effect
```

# Whoops

whoops is an error handler framework for PHP. Out-of-the-box, it provides a pretty error interface that helps you debug your web projects, but at heart it's a simple yet powerful stacked error handling system.

## Features
- Flexible, stack-based error handling
- Stand-alone library with (currently) no required dependencies
- Simple API for dealing with exceptions, trace frames & their data
- Includes a pretty rad error page for your webapp projects
- Includes the ability to open referenced files directly in your editor and IDE
- Includes handlers for different response formats (JSON, XML, SOAP)
- Easy to extend and integrate with existing libraries
- Clean, well-structured & tested code-base