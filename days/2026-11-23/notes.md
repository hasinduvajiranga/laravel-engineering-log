# Eloquent API Prometheus Export

The goal of this implementation is to expose the performance characteristics of our Eloquent-based Laravel API through Prometheus, allowing us to monitor and optimize its performance.

## Installation

To install this package, run `composer require app/providers/prometheus-exporter`.

## Configuration

In your `config/app.php` file, add a new provider for the `PrometheusExporter` class:
```php
'providers' => [
    // ...
    App\Providers\PrometheusExporter::class,
],
```
Also, make sure to configure Prometheus in your Laravel project by adding the following lines to your `.env` file:
```
PROMETHEUS_PORT=9091
PROMETHEUS_URL=http://localhost:9091/
```

## Usage

To use this package, simply add a new instance of the `PrometheusExporter` class to your Laravel provider chain. This will register the metrics with Prometheus and make them available at the specified URL.

Example:
```php
// app/Providers/config.php
'providers' => [
    // ...
    \App\Providers\PrometheusExporter::class,
],
```
## Metrics

This package exposes two metrics:

1. `users_count`: a metric that increments on each call to the User model.
2. (Other metrics can be added as needed)

To verify the metrics are being exported correctly, use a tool like `curl` or a web browser to access the Prometheus URL:
```bash
curl -s http://localhost:9091/
```
This should display the list of available metrics from your Laravel API.

## Notes

* Make sure to test this package thoroughly to ensure that it's working as expected.
* Consider adding more metrics and customizing the exporter to fit your specific use case.
* This implementation assumes a simple `User` model. In a real-world application, you may need to add additional logic to handle more complex scenarios.