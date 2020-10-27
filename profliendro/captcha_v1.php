<?php

session_start();

$captchacode       = '';
$captchaheight     = 40;
$captchawidth      = 180;
$captchachars      = 5;
$captchadots       = 30;
$captchalines      = 10;
$captchafontsize   = 50 * 0.45;
$captchaletters    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$captchafonts      = array('Roboto-Bold.ttf', 'Montserrat-Regular.ttf');
$captchafont       = dirname(__FILE__) . '/fonts/Roboto-Bold.ttf';
$captchafontdir    = dirname(__FILE__) . '/fonts/';
$captchabackcolor  = array('R' => 0xff, 'G' => 0xff, 'B' => 0xff);
$captchatextcolor  = array('R' => 0x34, 'G' => 0x3a, 'B' => 0x40);
$captchanoisecolor = array('R' => 0xff, 'G' => 0xc1, 'B' => 0x07);

$captchaimage      = imagecreate($captchawidth, $captchaheight);
$captchabackcolor  = imagecolorallocate($captchaimage, $captchabackcolor['R'], $captchabackcolor['G'], $captchabackcolor['B']);
$captchatextcolor  = imagecolorallocate($captchaimage, $captchatextcolor['R'], $captchatextcolor['G'], $captchatextcolor['B']);
$captchanoisecolor = imagecolorallocate($captchaimage, $captchanoisecolor['R'], $captchanoisecolor['G'], $captchanoisecolor['B']);

for($i = 0; $i < $captchachars; $i++)
{
    $captchacode .= substr($captchaletters, mt_rand(0, strlen($captchaletters) -1), 1);
}

for($i = 0; $i < $captchadots; $i++)
{
    imagefilledellipse($captchaimage, mt_rand(0, $captchawidth), mt_rand(0, $captchaheight), 2, 3, $captchanoisecolor);
}

for($i = 0; $i < $captchalines; $i++)
{
    imageline($captchaimage, mt_rand(0, $captchawidth), mt_rand(0, $captchaheight), mt_rand(0, $captchawidth), mt_rand(0, $captchaheight), $captchanoisecolor);
}


$captchabox = imagettfbbox($captchafontsize, 0, $captchafont, $captchacode);
$x = abs($captchabox[4] - $captchawidth)  / 2;
$y = abs($captchabox[5] - $captchaheight) / 2;


for ($i = 0; $i < strlen($captchacode); $i++)
{
    $angle = mt_rand(-35,  35);
    $image = imagettftext($captchaimage, $captchafontsize, $angle, $x - mt_rand(10, 20), $y, $captchatextcolor, $captchafontdir . $captchafonts[mt_rand(0, sizeof($captchafonts) -1)], $captchacode[$i]);
    $x += 8 + ($image[2] - $image[0]);
}

ob_start();
imagepng($captchaimage);
imagedestroy($captchaimage);
$b64image = ob_get_contents();
ob_end_clean();
echo 'data:image/png;base64,' . base64_encode($b64image);

$_SESSION['captcha'] = $captchacode;