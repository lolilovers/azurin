# Functions

| Function  | Description |
| ------------- | ------------- |
| get()  | Validate CSRF only for GET requests  |
| post()   | Validate CSRF only for POST requests   |
| all()   | Validate CSRF for GET & POST requests   |
| token()   | Generate CSRF Token   |
| flushToken()  | Remove all tokens |

# Usages

<p>
 This <b>CSRF-Handler</b> will look for a <i>form-data</i> / <i>url-parameter</i> called <b>_token</b>. To verify the request, <i>POST</i> request need to have a <b>_token</b> in <i>form-data</i>. And <i>GET</i> request need to have a <b>_token</b> in <i>url-parameter</i>.  
</p>


### Generating Token

```php
<form>
  <input type="hidden" name="_token" value="<?php echo csrf::token(); ?>">
</form>
```

### Validating Request

<b>GET Request Only</b>

```php
  $isValid = csrf::get(); // return TRUE or FALSE
  
  if ( $isValid ) {
  
    //Do something if valid
  
  } else {
  
    //Do something if not vaid
  
  }
```

<b>POST Request Only</b>

```php
  $isValid = csrf::post(); // return TRUE or FALSE
  
  if ( $isValid ) {
  
    //Do something if valid
  
  } else {
  
    //Do something if not vaid
  
  }
```

<b>GET & POST Request</b>

```php
  $isValid = csrf::all(); // return TRUE or FALSE
  
  if ( $isValid ) {
  
    //Do something if valid
  
  } else {
  
    //Do something if not vaid
  
  }
```


### Clear All Active Tokens

```php
  csrf::flushToken(); // will destroy all active tokens
```
