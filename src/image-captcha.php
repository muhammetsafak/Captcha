<?php
/**
 * image-captcha.php
 *
 * This file is part of Captcha.
 *
 * @author     Muhammet ŞAFAK <info@muhammetsafak.com.tr>
 * @copyright  Copyright © 2022 Captcha
 * @license    https://github.com/muhametsafak/Captcha/blob/main/LICENSE  MIT
 * @version    1.0
 * @link       https://www.muhammetsafak.com.tr
 */
if(!class_exists('\\MuhammetSafak\\Captcha\\Captcha')){
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'Captcha.php';
}
$captcha = new \MuhammetSafak\Captcha\Captcha();
$captcha->create();
