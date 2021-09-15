# Azurin 2.2
Simple PHP Framework

## Prerequisites
- Minimum PHP version 8
- Require mod_rewrite module enabled

## Installation
- Clone this repository
- Configure the .ENV file (azurin/.env)
- Point your server to public path

## Breaking from 1.x
- Deprecation mysqli wrapper, now use mysqli driver service
- Deprecation autoload, now use spl autoload register
- Sources (view,model,etc...) now moved to separated folder
- Router feature removed, now use magic routing
- Changed from MVVM pattern to MVC pattern

## New updates
- Dual renderer service(TemplateEngine & NativeRenderer)
- Enhanced logger, cookie, and session service
- Added input, output, and files service
- Added development mode and debug tool
- Added composer autoloading support
- Added global functions helper
- Added query builder factory
- Added CSP and CSRF support
- Added encryption service
- Added hot reload support
- Added command line tool
- Added .ENV support
