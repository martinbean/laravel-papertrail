# Laravel Papertrail log channel

## Requirements
* Your application must be running Laravel 5.6.

**Note:** Laravel added a native Papertrail logging channel in version 5.7, so if you are running Laravel 5.7+ this package is unnecessary.

## Installation
1. Set two environment variables: `PAPERTRAIL_HOST` and `PAPERTRAIL_PORT`.
2. Run `composer require martinbean/laravel-papertrail`
3. Open **config/logging.php** and add the following channel:

```php
'papertrail' => [
    'driver' => 'papertrail',
    'level' => 'debug', // Or other desired level
],
```

Once configured, you can add `papertrail` to the `stack` channel (if you’re
using it) and any logs will be pushed to your Papertrail account.

**Note:** The `PAPERTRAIL_HOST` environment variable should be the _full_
Papertrail hostname, i.e. **logs0.papertrailapp.com**.

## Issues
[Open a new Issue](https://github.com/martinbean/laravel-papertrail/issues/new)
on the [GitHub repository](https://github.com/martinbean/laravel-papertrail).

## License
Licensed under the [MIT License](LICENSE.md).
