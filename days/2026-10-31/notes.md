### Eloquent API Caching Headers

Laravel provides a simple way to cache responses using the `Cache` facade. However, it does not directly support caching headers like `If-None-Match`. To achieve this, we need to manually handle the caching of headers.

The `$cacheHeaders` property on the `User` model allows us to specify which headers should be cached when retrieving data from Eloquent. In this example, we're caching `If-Modified-Since` and `Cache-Control` headers.

We also provide a custom cache duration for each route using the `getCacheDuration()` method. This ensures that the cache is updated regularly to prevent stale data from being returned.

When handling GET requests, we first check if the `If-None-Match` header is present in the request. If it is, we create a cache key based on the request and the previous response. We then check if the cache key already exists in the cache store. If it does, we return the cached response with a 304 status code.

If the cache key does not exist or has expired, we generate the data again using Eloquent and cache it for the specified duration. This approach ensures that subsequent requests with the same `If-None-Match` header receive the updated data without having to re-fetch it from the database.

In our tests, we verify that:

*   The cached response is returned correctly when the `If-None-Match` header is present.
*   The cache is updated correctly when the `If-None-Match` header changes.
*   The cache does not exist or has expired when no headers are provided.