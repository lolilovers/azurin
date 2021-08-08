# Azurin Micro Framework v2.2

## Breaking details
1. Changed from MVVM pattern to MVC pattern
2. Deprecation javascript redirect, now using HTTP redirect
3. Deprecation for send_404 function, now handled by response handler
4. Deprecation for javascript console function
5. Router feature removed, now use magic routing
6. Deprecation autoload, now use spl autoload register
7. Deprecation cache helper, now use cache service
8. Source(view,model,etc...) now moved to src folder
9. Deprecation mysqli wrapper, now use mysqli driver service

## New updates
1. Dual renderer service(TemplateEngine & NativeRenderer)
2. Enhanced logger, cookie, and session service
3. Added .ENV support
4. Added development mode
6. Added encryption service
7. Added query builder factory
8. Added CSRF service
9. added content security policy
10. New input, output, and files service
11. Added command line tool
12. Added hot reload support
