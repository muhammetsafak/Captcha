# Captcha

It's simply an old-school captcha app.

<center><img src="https://user-images.githubusercontent.com/9823597/160092903-c6ba0a20-0391-4c2b-8b9d-68f5b6da7603.jpg" alt="php-basic-captcha" /></center>

## Requirements

- PHP 5.6 or higher
- PHP GD Extension

## Installation

```
composer require muhammetsafak/captcha:dev-main
```

or download and include the file `src/Captcha.php`.

## Usage

The file `src/image-captcha.php` simply generates and presents a captcha for you. You can edit this file for a custom configuration or create your own.

### Configuration
```
$configs = array(
    'width'         => 200, // Width of captcha image to be created
    'height'        => 70, // Height of captcha image to be created
    'length'        => 7, // The number of characters to be found in the captcha image.
    'font'          => __DIR__ . '/src/AHGBold.ttf', // Defines the font of the captcha characters.
    'size'          => 18 // Defines the size of captcha characters.
);
```

To create a captcha image; `image-captcha.php`

```php
require_once __DIR__ . '/src/Captcha.php';
$config = array(
    'width'         => 180,
    'height'        => 50,
    'length'        => 6
);
$captcha = new \MuhammetSafak\Captcha\Captcha($config);
$captcha->create();
```

```html
<form method="POST">
    <input type="text" name="your_name" placeholder="Your Name"/><br />
    
    <img src="src/image-captcha.php" id="captcha" /> <br />
    <button onclick="captcha_refresh()">Refresh</button>
    <input type="text" name="areYouBot" placeholder="Captcha" /><br />
    
    <input type="submit" value="Gönder" />
</form>
<script>
    function captcha_refresh()
    {
        img = document.getElementById("captcha");
        img.src = '../src/image-captcha.php';
    }
</script>
```

A simple validation example is as follows.

```php
require_once __DIR__ . '/src/Captcha.php';
$captcha = new \MuhammetSafak\Captcha\Captcha();
if(isset($_POST)){
    if($captcha->verify($_POST['areYouBot'])){
        // Success
        // ...process
    }else{
        // Error
        echo 'Enter the characters in the picture correctly.';
    }
}
```

## Licence

Copyright &copy; 2022 [MIT License](./LICENSE)
