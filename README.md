###IlluminateRequestPSR7Adapter

The Laravel/Lumen component Illuminate\Http depends on symfony\Http-Kernel
which doesn't implement PSR-7 Requests (BOOOO!!!!)

I want to use them cool PSR-7 interoperability middleware libraries to cut down
on developing components specifically for lumen.

Since all middleware in laravel/lumen need a illuminate\http\request object
here is a simple middleware which when loaded first will convert all subsequent
middleware requests to fully PSR-7 compliant objects.