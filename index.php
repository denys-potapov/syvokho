<?php

require_once('syvokho.php');

function pluralForm($n, $forms)
{
    if (($n % 10 == 1) && ($n % 100 != 11)) {
        return $forms[0];
    }

    if ((($n % 10) >= 2) && (($n % 10) <= 4)) {
        if ((($n % 100) < 10) || (($n % 100) >= 20)) {
            return $forms[1];
        };
    };

    return  $forms[2];
}

function centerText($im, $y, $text, $font, $size, $color)
{
    $center = imagesx($im) / 2;
    list($left, , $right, , ,) = imageftbbox($size, 0, $font, $text);

    $x = $center - ($right - $left) / 2;
    $y = $y + $size / 2;
    imagettftext($im, $size, 0, $x, $y, $color, $font, $text);
}

$qs = $_SERVER['QUERY_STRING'];
$debug = (strpos($qs, 'debug') !== false);
$days = intval($qs);

$realDays = date_diff($syvokhoTime, date_create())->days;
if (($days != $realDays) && (!$debug)) {
    header("Location: /?$realDays", true, 307);
    exit;
}

$title = "Скільки днів не били Сивоху?";
$text = pluralForm($days, ["день", "дні", "днів"]);
$answer = "Сивоху не били";
$description = "$answer $days $text";

$path = "images/$days.png";
if (!file_exists($path)) {
    $w = 1200;
    $h = 630;
    $im = imagecreatetruecolor($w, $h);

    $bg = imagecolorallocate($im, 0xff, 0x52, 0x52);
    imagefill($im, 0, 0, $bg);

    $white = imagecolorallocate($im, 255, 255, 255);

    centerText($im, 120, $answer, "fonts/Roboto-Bold.ttf", 70, $white);
    centerText($im, $h / 2, $days, "fonts/Roboto-Medium.ttf", 160, $white);
    centerText($im, 500, $text, "fonts/Roboto-Bold.ttf", 70, $white);

    imagepng($im, $path);
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo "$description"; ?>">
      
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://xn--b1altal1a.xn--j1amh/" />
    <meta property="og:title" content="<?php echo $title; ?>" />
    <meta property="og:description" content="<?php echo $description; ?>" />
    <meta property="og:image" content="https://xn--b1altal1a.xn--j1amh/<?php echo "$path"; ?>" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    <style>
      body, html{
        height: 100%;
      }
      body {
        height: 90vh;
        background-color: #ff5252;
        margin: 0;
        color: white;
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        text-align: center;
      }
      .container {
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
      }
      .footer {
        position: absolute;
        top: 90vh;
        left: 50%;
        transform: translate(-50%, 0);
      }
      h1 {
        margin: 0;
        font-weight: 700;
        font-size: 5em;
      }
      @media only screen and (max-width: 770px) {
        h1 {
          font-size: 3em;
        }
        .footer a {
          display: block;
          padding-bottom: 1em;
          padding-top: 1em;
        }
      }
      #days {
        display: block;
        font-size: 200%;
      }
      a {
        color: white;
        text-decoration: none;
      }
      .fb-share-button {
        padding-left: 3em;
        padding-right: 3em;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <h1>
        Сивоху не&nbsp;били <span id="days"><?php echo $days; ?></span> 
        <?php echo $text; ?></h1>
    </div>
    <div class="footer">
      <a href="https://github.com/denys-potapov/syvokho">github</a>
      <div class="fb-share-button" data-href="https://&#x441;&#x438;&#x432;&#x43e;&#x445;&#x43e;.&#x443;&#x43a;&#x440;/" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fxn--b1altal1a.xn--j1amh%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Поширити</a></div>
      <a href="https://www.denyspotapov.com/">Денис Потапов</a>
    </div>
  </body>

  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/uk_UA/sdk.js#xfbml=1&version=v6.0&appId=599480133566803&autoLogAppEvents=1"></script>

  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-160647519-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-160647519-1');
  </script>
</html>
