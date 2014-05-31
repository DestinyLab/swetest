# Swetest

Swetest is the simple wrapper of swisseph library's swetest.

## Requirement

 - PHP >=5.4

## Installing via Composer

The recommended way to install Swetest is through Composer.

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, update your project's composer.json file to include Swetest:

```json
{
    "require": {
        "destinylab/swetest": "dev-master"
    }
}
```

## Usage

```php
<?php

require_once 'vendor/autoload.php';

use DestinyLab\Swetest;
$swetest = new Swetest();

// ephemeris of Mercury (-p2) starting on 1 Dec 1900,
// 15 positions (-n15) in two-day steps (-s2)
$swetest->query('-b5.1.2002 -p -house12.05,49.50,k -ut12:30')->execute();

// angular distance of moon (-p1) from sun (-d0) for 10
// consecutive days (-n10).
$swetest->query('-p1 -d0 -b1.12.1900 -n10 -fPTl -head')->execute();

// Midpoints between Saturn (-p6) and Chiron (-DD) for 100
// consecutive steps (-n100) with 5-day steps (-s5) with
// longitude in degree-sign format (-f..Z) rounded to minutes (-roundmin)
$swetest->query('-p6 -DD -b1.12.1900 -n100 -s5 -fPTZ -head -roundmin')->execute();

// get response (status + output)
print_r($swetest->response());

// or just get status
print_r($swetest->getStatus());

// or just get output
print_r($swetest->getOutput());
```

## Configuration

Mask swetest executable path (default to `true`):

```php
<?php

$swetest->maskPath(true);
```

Changing the swetest file's path:

```php
<?php

require_once 'vendor/autoload.php';

use DestinyLab\Swetest;

// method 1
$swetest = new Swetest('/path/to/swetest');

// method 2
$swetest = new Swetest();
$swetest->setPath('/path/to/swetest');
```

The resource by default includes following files:
 - seas_18.se1
 - semo_18.se1
 - sepl_18.se1

If you need more file, just download from <http://www.astro.com/ftp/swisseph/ephe/>.

## More Infomation

 - [swetest help](http://www.astro.com/cgi/swetest.cgi?arg=-h&p=0)

## License

MIT