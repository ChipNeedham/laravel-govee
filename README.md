# Laravel Govee Connector 💡

A Laravel package for interacting with the Govee Smart Home API, allowing easy control and management of Govee smart devices. At the moment only lights are supported.

## Installation

You can install the package via Composer:

```bash
composer require chipneedham/laravel-govee
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag="config"
```

This will create a `config/govee.php` file. Add your Govee API key to your `.env` file:

```php
GOVEE_API_KEY=your_govee_api_key_here
```
### Getting an API key
[See Govee's Docs](https://developer.govee.com/reference/apply-you-govee-api-key)

## Usage

### Retrieving Devices

```php
use Govee;

// Get all Govee devices
$devices = Govee::getDevices();

foreach ($devices as $device) {
    echo $device->name; // Device name
    echo $device->deviceId; // Device ID
}
```

### Device Control

```php
// Turn a device on/off
$device->setPowerState(true); // Turn on
$device->setPowerState(false); // Turn off

// Set brightness (1-100)
$device->setBrightness(50);

// Set color using RGB
$device->setColor(255, 0, 0); // Red

// Set color using Hex
$device->setHexColor('#00FF00'); // Green

// Set white color temperature (2000-9000K)
$device->setWhiteTemperature(4000);
```

### Directly Accessing a Device

```php
// If you know the device ID and model
$specificDevice = Govee::getDevice('your-device-id', 'your-device-model');
```

### Rate Limits

Govee's rate limits are annoyingly low. Sorry.

| Endpoint         | Limit                    |
|------------------|--------------------------|
| DeviceList       | 10 per minute           |
| DeviceControl    | 10 per minute per device |
| DeviceState      | 10 per minute per device |
| Total Requests   | 10000 per day           |

## Error Handling

Error handling has a lot of work to be done, at the moment be sure to use trys.
The package throws exceptions for invalid inputs or API errors:

```php
try {
    $device->setBrightness(150); // Will throw an exception
} catch (\Exception $e) {
    // Handle error
    echo $e->getMessage();
}
```

## Facade

The package includes a `Govee` facade for easy access to the Govee API client.

## Requirements

- PHP 8.1+
- Laravel 10.x+
- Govee API Key

## Security

Please ensure your Govee API key is kept secure and not committed to version control.

## Contributing

Contributions are welcome! Please submit pull requests or file issues on the GitHub repository.

## Support

If you encounter any issues or have questions, please file an issue on the GitHub repository.
