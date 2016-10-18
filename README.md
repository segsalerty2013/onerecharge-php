Onerecharge PHP client library for Agent's integration for bill payments
========================================================================

- To know more about or become an Agent on Onerecharge, Visit  [www.onerecharge.com](http://onerecharge.com)

## Features

- Get an Authorization token (Retrieve `API ACCESS KEY` from your agent dashboard)
- Get supported bill payment
- Initiate instant recharge/topup (Airtime)
- Initiate scheduled recharge/topup (Airtime)
- Cancel a scheduled bill payment
- Get your Agent account profile summary in one

## Examples

- Initiate an instant recharge/topup (Airtime)
```php
    use Onerecharge\Agent;
    use Onerecharge\Util;
    use Onerecharge\BillPayment;

    //use the Util function like this to get array of supported telco names:
    echo Util::getSupportedBillType();
    //then get an Authorization token. you should store the retrieved token somewhere in your code.
    //tokens can be destroyed from your admin portal anytime (do not store your agent_id and password in your code.)
    $token = Agent::getToken($agent_id, $password);

    $agent = new Agent(API_ACCESS_KEY, $token);
    $billpayment = new BillPayment($agent);
    echo $billpayment->airtimeTopup("08025***373", "Etisalat", 100);
```
## Installing onerecharge-php

The recommended way to install onerecharge-php is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of Guzzle:

```bash
php composer.phar require onerecharge/onerecharge-php
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

You can then later update onerecharge-php using composer:

 ```bash
composer.phar update
 ```
