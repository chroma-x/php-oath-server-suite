# Oath Server Suite

[![Build Status](https://travis-ci.org/markenwerk/php-oath-server-suite.svg?branch=master)](https://travis-ci.org/markenwerk/php-oath-server-suite)
[![Code Climate](https://codeclimate.com/github/markenwerk/php-oath-server-suite/badges/gpa.svg)](https://codeclimate.com/github/markenwerk/php-oath-server-suite)
[![Issue Count](https://codeclimate.com/github/markenwerk/php-oath-server-suite/badges/issue_count.svg)](https://codeclimate.com/github/markenwerk/php-oath-server-suite)
[![Latest Stable Version](https://poser.pugx.org/markenwerk/oath-server-suite/v/stable)](https://packagist.org/packages/markenwerk/oath-server-suite)
[![Total Downloads](https://poser.pugx.org/markenwerk/oath-server-suite/downloads)](https://packagist.org/packages/markenwerk/oath-server-suite)
[![License](https://poser.pugx.org/markenwerk/oath-server-suite/license)](https://packagist.org/packages/markenwerk/oath-server-suite)

A collection of classes to provide second factor authentication (Yubico OTP, TOTP, HOTP, GoogleAuthenticator) server-side.

## Installation

```{json}
{
   	"require": {
        "markenwerk/oath-server-suite": "~1.0"
    }
}
```

## Usage

### Autoloading and namesapce

```{php}  
require_once('path/to/vendor/autoload.php');

use OathServerSuite;
```

---

### OTP (YubiCloud)

For more information about the authentication mechanism read the „What is YubiKey OTP?“ article at [https://developers.yubico.com/OTP/](https://developers.yubico.com/OTP/).

To use OTP you need YubiCloud access. You can get free API credentials from [https://upgrade.yubico.com/getapikey/](https://upgrade.yubico.com/getapikey/).

##### Validating an OTP

```{php}
$otp = $_POST['otp'];
$userPublicId = $fetchedFromDatabaseOrSimilar;

$validator = new OathServerSuite\Otp\Validator('yubiCloudClientId', 'yubiCloudSecretKey');
try {
	$validator->validate($otp, $userPublicId);
	// Validation was success e.g. no exception was thrown.
} catch (OathServerSuite\Exception\NetworkException $exception) {
	// Accessing the YubiCloud webservice failed.
} catch (OathServerSuite\Exception\ValidationFailedException $exception) {
	if ($exception->getCode() == 1) {
		// The given OTP is not wellformed.
	} else if ($exception->getCode() == 2) {
		// The given OTP does not match the users public ID.
	} else if ($exception->getCode() == 3) {
		// The given OTP is not valid.
	}
}
```

## License

Oath Server Suite is under the MIT license.