### Eloquent API Last-Modified Headers

Eloquent provides a convenient way to set the `Last-Modified` header in your responses. The `header()` method allows you to add custom headers to your responses.

To use this feature, simply call the `header()` method on your response object and pass the desired value for the `Last-Modified` header. In Eloquent, we're using `Carbon::now()->toRfc3328()` to get the current time in RFC 3328 format, which is a standard for representing dates and times.

When you make an API request with the `Last-Modified` header, your server will respond with the same value in the response headers. This allows clients to keep track of when the resource was last modified.

Note that setting the `Last-Modified` header is optional, but it can be useful for implementing caching and other features that rely on date-based expiration.