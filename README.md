# Azurin Framework v2.2
Simple PHP Framework

## Prerequisites
Min PHP v8.x

## Breaking from v1.x
- Deprecation for send_404 function, now handled by response handler
- Deprecation mysqli wrapper, now use mysqli driver service
- Deprecation autoload, now use spl autoload register
- Source(view,model,etc...) now moved to src folder
- Deprecation cache helper, now use cache service
- Router feature removed, now use magic routing
- Changed from MVVM pattern to MVC pattern

## New updates
- Dual renderer service(TemplateEngine & NativeRenderer)
- Enhanced logger, cookie, and session service
- New input, output, and files service
- Added composer autoloading support
- Added content security policy
- Added global functions helper
- Added query builder factory
- Added encryption service
- Added hot reload support
- Added command line tool
- Added development mode
- Added CSRF service
- Added .ENV support
- Added debug tool
