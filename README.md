# Usage

Copy *CertCenter.inc.php* to your favorite library folder. 
Here's how you can make a simple function call to the CertCenter REST API.

```php
require_once '../my-lib-folder/CertCenter.inc.php';
use CertCenter\RESTful as ccAPI;
$api = new ccAPI();

$limits = $api->Limit();
print_r($limits);
```

# Credentials

Before you're able to make function calls against the REST api you
need to put your credentials to the CertCenter.inc.php file. Just
open that file with your editor and replace the existing authorization
information with your active and valid OAuth2 bearer token.

``` php
private $__authorization = Array('Bearer'=> 'XYZXYZXYZ.oauth2.certcenter.com');
```

# Where can I get my OAuth2 bearer token?

It's quite easy and a howto is already available:


- <a target="_blank" href="https://blog.certcenter.com/2015/11/how-does-it-actually-work-to-access-the-certcenter-restful-api/">English version</a>
- <a target="_blank" href="https://blog.certcenter.de/2015/10/demo-zugriff-certcenter-restful-api/">German version</a>
