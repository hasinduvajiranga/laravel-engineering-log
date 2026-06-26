# Streamed Responses

Streamed responses in Laravel allow you to send large files as a response without having to load them into memory. This can be particularly useful for handling large attachments or streaming data from an external source.

## Creating a Stream Wrapper

To create a streamed response, you'll need to use the `fopen` function to create a stream wrapper. The `php://temp` prefix tells PHP to use a temporary file as the stream wrapper.

```php
$stream = fopen('php://temp', 'r+');
```

## Setting Headers

You'll also need to set some headers for your streamed response:

*   `Content-Disposition`: specifies that this is an attachment and should be saved with this name.
*   `Content-Type`: specifies the type of data in the response (in this case, a CSV file).
*   `Accept-Ranges`: tells the client how many chunks of the stream it can request.

```php
Response::header('Content-Disposition: attachment; filename="example.csv"');
Response::header('Content-Type: text/csv');
Response::header('Accept-Ranges: bytes');
```

## Streaming Data

To send a chunk of data to the client as a stream, you'll need to use `fwrite` and set some headers.

```php
$chunk = str_repeat(',', 1000);
fwrite($stream, $chunk);

header('Content-Range: bytes 1-' . ($totalBytes - 1000) . '/' . $totalBytes);
```

## Returning a Response Object

Finally, you'll need to return a `Response` object with the stream wrapper.

```php
return new Response($stream, 200, [
    'Content-Disposition' => 'attachment; filename="example.csv"',
    'Content-Type' => 'text/csv',
]);
```

This allows Laravel to handle the streaming for you and ensure that the response is sent correctly to the client.