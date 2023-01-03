# Laravel Smsonline GH Sms Api

<!-- [![GitHub issues](https://img.shields.io/github/issues/SanakeyAugustineAyiku/laravel-smsonline)](https://github.com/SanakeyAugustineAyiku/laravel-smsonline/issues)
[![GitHub stars](https://img.shields.io/github/stars/SanakeyAugustineAyiku/laravel-smsonline)](https://github.com/SanakeyAugustineAyiku/laravel-smsonline/stargazers)
[![GitHub license](https://img.shields.io/github/license/SanakeyAugustineAyiku/laravel-smsonline)](https://github.com/SanakeyAugustineAyiku/laravel-smsonline/blob/main/LICENSE)
[![Build Status](https://travis-ci.com/SanakeyAugustineAyiku/laravel-smsonline.svg?branch=main)](https://travis-ci.com/SanakeyAugustineAyiku/laravel-smsonline) -->

## Send Laravel Notifications via the smsonline GH SMS API

## Installation

You can install the package via composer:

```bash
composer require aasanakey/smsonline
```

First you must install the service provider (skip for Laravel>=5.5):

```php
// config/app.php
'providers' => [
    ...
    \Aasanakey\Smsonline\SmsonlineServiceProvider::class,
],
```

<!-- In order to let your Notification know which phone number you are targeting, add the routeNotificationForMnotify method to your Notifiable model.

```php

class User extends Model
{
     public function routeNotificationForMnotify()
    {
        return $this->contact;  // returns a contact number eg 0301045697
    }
}
``` -->

You can publish the config file with:

```bash
php artisan vendor:publish --tag=smsonline-config
```

or

```bash
php artisan vendor:publish --provider="Aasanakey\Smsonline\SmsonlineServiceProvider" --tag="smsonline-config"
```

## Configuration

Add your smsonline Gh api access key, api host, sender Id/sender name. 

Set your smsonline Gh api keys in your .env file.

```
SMSONLINE_HOST=Sms online api host
```

Or

Add api host  to your `config/smsonline.php`:

```php
// config/services.php
...
"host" => env('SMSONLINE_HOST','api.smsonlinegh.com'),
...
```

Set your smsonline Gh api keys in your .env file.

```
SMSONLINE_API_KEY=your smsonline api key
```

Or

Add your API Key  to your `config/smsonline.php`:

```php
// config/services.php
...
"api_key" => env('SMSONLINE_API_KEY',null),
...
```

For your smsonline  API Key visit [SMS API](https://portal.smsonlinegh.com/account/api/options)


Set your smsonline Gh sender Id in your .env file.

```
SMSONLINE_SENDER_ID=your sender ID
```

Or

Add your Send Id to your `config/smsonline.php`:

```php
// config/services.php
...
"sender_id" => env('SMSONLINE_SENDER_ID',null),
...
```

For your smsonline  API Key visit [Sender Name](https://portal.smsonlinegh.com/message/sms/senders)


## Usage

Now you can use the channel in your `via()` method inside the notification as well as send an sms notification using the smsonline api:

```php
use Illuminate\Notifications\Notification;
use Aasanakey\Smsonline\SmsonlineSmsMessage;


class SMSNotification extends Notification
{
    public function via($notifiable)
    {
        return ['smsonlinegh'];
    }

    public function toSmsonline($notifiable)
    {
        return (new SmsonlineSmsMessage)
            ->sender('Sender ID')
            ->content('Your account was approved!')
            ->personalisedValues("List of data for personnalised message content"); // call this method if content has message variables placeholders
    }
}
```

### Check balance

To check your sms balance use the `checkBalance()` method on SMSAPI object:

```php
use Aasanakey\Smsonline\Sms;

$sms = new Sms();
$balance = $api->balance(); // returns balance info object
$amount = $balance->ammount // returns balance ammount
$currencyName = $balance->currencyName // returns the balance currency name
$currencyCode = $balance->currencyCode // return the balance ccurrency code
```

<!-- ## License

The MIT License (MIT). Please see [License File](LICENSE) for more information. -->