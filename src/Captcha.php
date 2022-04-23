<?php
/**
 * Captcha.php
 *
 * This file is part of Captcha.
 *
 * @author     Muhammet ŞAFAK <info@muhammetsafak.com.tr>
 * @copyright  Copyright © 2022 Captcha
 * @license    https://github.com/muhammetsafak/Captcha/blob/main/LICENSE  MIT
 * @version    1.0
 * @link       https://www.muhammetsafak.com.tr
 */

namespace MuhammetSafak\Captcha;

use const DIRECTORY_SEPARATOR;

use function array_merge;
use function session_status;
use function session_start;
use function count;
use function rand;
use function imagecreatetruecolor;
use function imagecolorallocate;
use function imagefill;
use function imagesetthickness;
use function imageline;
use function imagettftext;
use function implode;
use function header;
use function imagepng;
use function imagedestroy;
use function trim;

class Captcha
{

    /** @var string[] */
    protected $chars = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
    );

    /** @var array */
    protected $configs = array(
        'width'         => 200,
        'height'        => 70,
        'length'        => 7,
        'font'          => __DIR__ . DIRECTORY_SEPARATOR . 'AHGBold.ttf',
        'size'          => 18
    );

    /** @var resource|\GdImage */
    protected $image;

    /** @var int */
    protected $charStep = 22;

    /** @var string */
    protected $captcha = '';


    public function __construct($configs = array())
    {
        if(!empty($configs)){
            $this->configs = array_merge($this->configs, $configs);
        }
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }
        if($this->charStep <= $this->configs['size']){
            $this->charStep = $this->configs['size'] + 1;
        }
        $this->captcha = isset($_SESSION['captcha']) ? (string)$_SESSION['captcha'] : '';
    }

    /**
     * @return string
     */
    public function getCaptcha()
    {
        return $this->captcha;
    }

    /**
     * @return array
     */
    public function randomCaptcha()
    {
        $chars = array();
        $charCount = count($this->chars);
        for ($i = 0; $i < $this->configs['length']; ++$i) {
            $chars[] = $this->chars[rand(0, $charCount)];
        }
        return $chars;
    }

    public function create()
    {
        if($this->configs['width'] < ($this->configs['length'] * $this->charStep)){
            $this->configs['width'] = ($this->configs['length'] * $this->charStep) + $this->charStep;
        }
        if(($this->image = @imagecreatetruecolor($this->configs['width'], $this->configs['height'])) === FALSE){
            throw new \RuntimeException();
        }
        $bg = imagecolorallocate($this->image, 0xFF, 0xFF, 0xFF);
        imagefill($this->image, 0, 0, $bg);
        $lineColor = imagecolorallocate($this->image, 0xCC, 0xCC, 0xCC);
        $color = imagecolorallocate($this->image, 0x33, 0x33, 0x33);

        for ($i = 0; $i <= 5; ++$i) {
            imagesetthickness($this->image, rand(1, 3));
            imageline(
                $this->image,
                0,
                rand(0, $this->configs['height']),
                $this->configs['width'],
                rand(0, $this->configs['height']),
                $lineColor
            );
        }

        $captcha = $this->randomCaptcha();

        $length = ($this->configs['length'] * $this->charStep);
        $startX = ($this->configs['width'] - $length) / 2;
        $startX -= $this->charStep;
        $startY = $this->configs['height'] / 2;


        $x = 1;
        foreach ($captcha as $char) {
            imagettftext(
                $this->image,
                $this->configs['size'],
                (float)range(-20, 20),
                (int)($startX + ($x * $this->charStep)),
                (int)$startY - rand(-6, 10),
                $color,
                $this->configs['font'],
                $char
            );
            ++$x;
        }
        $this->captcha = $_SESSION['captcha'] = implode('', $captcha);
        header('Content-type: image/png');
        imagepng($this->image);
        imagedestroy($this->image);
    }

    /**
     * @param string $captcha
     * @return bool
     */
    public function verify($captcha)
    {
        $captcha = (string)$captcha;
        if(empty($this->captcha) || empty(trim($captcha))){
            return false;
        }
        return $this->captcha === $captcha;
    }

}
