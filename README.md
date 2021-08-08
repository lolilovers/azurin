# Azurin Framework v2.2
Simple PHP Framework

## Prerequisites
Min PHP v8.x

## Breaking from v1.x
1. Deprecation for send_404 function, now handled by response handler
2. Deprecation mysqli wrapper, now use mysqli driver service
3. Deprecation javascript redirect, now using HTTP redirect
4. Deprecation autoload, now use spl autoload register
5. Source(view,model,etc...) now moved to src folder
6. Deprecation cache helper, now use cache service
7. Router feature removed, now use magic routing
8. Deprecation for javascript console function
9. Changed from MVVM pattern to MVC pattern

## New updates
1. Dual renderer service(TemplateEngine & NativeRenderer)
2. Enhanced logger, cookie, and session service
3. New input, output, and files service
4. Added content security policy
5. Added query builder factory
6. Added encryption service
7. Added hot reload support
8. Added command line tool
9. Added development mode
10. Added CSRF service
11. Added .ENV support
