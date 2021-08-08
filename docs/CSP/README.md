# Content Security Policy Builder

CSPBuilder is a fork of paragonie/csp-builder

## Build a Content Security Policy header from a JSON configuration file

```php
<?php

use Azurin\Framework\CSP\CSPBuilder;

$csp = CSPBuilder::fromFile('/path/to/source.json');
$csp->sendCSPHeader();

```

You can also load the configuration from a JSON string, like so:

```php
<?php

use Azurin\Framework\CSP\CSPBuilder;

$configuration = file_get_contents('/path/to/source.json');
if (!is_string($configuration)) {
    throw new Error('Could not read configuration file!');
}
$csp = CSPBuilder::fromData($configuration);
$csp->sendCSPHeader();

```

Finally, you can just pass an array to the first argument of the constructor:

```php
<?php

use Azurin\Framework\CSP\CSPBuilder;

$configuration = file_get_contents('/path/to/source.json');
if (!is_string($configuration)) {
    throw new Error('Could not read configuration file!');
}
$decoded = json_decode($configuration, true);
if (!is_array($decoded)) {
  throw new Error('Could not parse configuration!');
}
$csp = new CSPBuilder($decoded);
$csp->sendCSPHeader();

```


### Example

```json
{
    "report-only": false,
    "report-to": "PolicyName",
    "report-uri": "/csp_violation_reporting_endpoint",
    "base-uri": [],
    "default-src": [],    
    "child-src": {
        "allow": [
            "https://www.youtube.com",
            "https://www.youtube-nocookie.com"
        ],
        "self": false
    },
    "connect-src": [],
    "font-src": {
        "self": true
    },
    "form-action": {
        "allow": [
            "https://example.com"
        ],
        "self": true
    },
    "frame-ancestors": [],
    "img-src": {
        "blob": true,
        "self": true,
        "data": true
    },
    "media-src": [],
    "object-src": [],
    "plugin-types": [],
    "script-src": {
        "allow": [
            "https://www.google-analytics.com"
        ],
        "self": true,
        "unsafe-inline": false,
        "unsafe-eval": false
    },
    "style-src": {
        "self": true
    },
    "upgrade-insecure-requests": true
}
```

## Build a Content Security Policy, programmatically

```php
<?php

use Azurin\Framework\CSP\CSPBuilder;

$csp = CSPBuilder::fromFile('/path/to/source.json');

// Let's add a nonce for inline JS
$nonce = $csp->nonce('script-src');
$body .= "<script nonce={$nonce}>";
    $body .= $desiredJavascriptCode;
$body .= "</script>";

// Let's add a hash to the CSP header for $someScript
$hash = $csp->hash('script-src', $someScript, 'sha256');

// Add a new source domain to the whitelist
$csp->addSource('image', 'https://ytimg.com');

// Set the Report URI
$csp->setReportUri('https://example.com/csp_report.php');

// Let's turn on HTTPS enforcement
$csp->addDirective('upgrade-insecure-requests', true);

$csp->sendCSPHeader();
```

Note that many of these methods can be chained together:

```php
$csp = CSPBuilder::fromFile('/path/to/source.json');
$csp->addSource('image', 'https://ytimg.com')
    ->addSource('frame', 'https://youtube.com')
    ->addDirective('upgrade-insecure-requests', true)
    ->sendCSPHeader();
```

* `addSource()`
* `addDirective()`
* `disableOldBrowserSupport()`
* `enableOldBrowserSupport()`
* `hash()`
* `preHash()`
* `setDirective()`
* `setBlobAllowed()`
* `setDataAllowed()`
* `setFileSystemAllowed()`
* `setMediaStreamAllowed()`
* `setReportUri()`
* `setSelfAllowed()`
* `setAllowUnsafeEval()`
* `setAllowUnsafeInline()`

## Inject a CSP header into a PSR-7 message

Instead of invoking `sendCSPHeader()`, you can instead inject the headers into
your PSR-7 message object by calling it like so:

```php
/**
 * $yourMessageHere is an instance of an object that implements 
 * \Psr\Http\Message\MessageInterface
 *
 * Typically, this will be a Response object that implements 
 * \Psr\Http\Message\ResponseInterface
 *
 * @ref https://github.com/guzzle/psr7/blob/master/src/Response.php
 */
$csp->injectCSPHeader($yourMessageHere);
```

## Save a CSP header for configuring Apache/nginx

Instead of calling `sendCSPHeader()` on every request, you can build the CSP once
and save it to a snippet for including in your server configuration:

```php
$policy = CSPBuilder::fromFile('/path/to/source.json');
$policy->saveSnippet(
    '/etc/nginx/snippets/my-csp.conf',
    CSPBuilder::FORMAT_NGINX
);
```

Make sure you reload your webserver afterwards.
