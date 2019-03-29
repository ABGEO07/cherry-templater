# Cherry-Templater
The Cherry-project Template wrapper

[![GitHub license](https://img.shields.io/github/license/abgeo07/cherry-templater.svg)](https://github.com/ABGEO07/cherry-templater/blob/master/LICENSE)

[![GitHub release](https://img.shields.io/github/release/abgeo07/cherry-templater.svg)](https://github.com/ABGEO07/cherry-templater/releases)

[![Packagist Version](https://img.shields.io/packagist/v/cherry-project/templater.svg "Packagist Version")](https://packagist.org/packages/cherry-project/templater "Packagist Version")

------------

## Including
**Install from composer** `composer require cherry-project/templater`

**Include Autoloader in your main file** (Ex.: index.php)
```php
require_once __DIR__ . '/vendor/autoload.php';
```

## Class Templater
Import class
```php
use Cherry\Templating\Templater;
```
Crete class new object
```php
$templateEngine = new Templater(PATH_TO_TEMPLATES);
```

Where `PATH_TO_TEMPLATES` is path to your templates folder. Ex.: `__DIR__ . '/../examples/templates'`

Create new template in you'r templates folder (Ex.: `index.templater.php`) which contains simple HTML 
Markup with PHP

```php
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hello, World!</title>
</head>
<body>
    <h1>Hello, <?php echo $name; ?>!</h1>
</body>
</html>
```

Then you can call `$templateEngine` objects `render` method with two arguments:

- Name of rendering template
- Arguments (PHP Variables) for template

Arguments is simple PHP Array:

```php
$args = [
    'name' => 'Name 1',
    'surname' => 'Surname 1'
];
```

Our index.templater.php template contains ony one PHP Variable `$name`, so we must pass it in `render` method:

```php
$response = $templateEngine->render('index', [
    'name' => 'Temuri'
]);
```

After that `$response` Variable will contain Response object and we can print it

```php
echo $response;
```

In first argument of `render` method we can put full filename of template (`index.templater.php`)
or only template name (name without file extension Ex.: `index`)

**2019 &copy; Cherry-project**
