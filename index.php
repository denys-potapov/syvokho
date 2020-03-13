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

$qs = $_SERVER['QUERY_STRING'];
$debug = (strpos($qs, 'debug') !== false);
$requestedDays = intval($qs);

$days = date_diff($syvokhoTime, date_create())->days;
if (($days != $requestedDays) && (!$debug)) {
    header("Location: /?$days", true, 307);
    exit;
}

$title = "Скільки днів не били Сивоху?";
$days = $requestedDays;
$text = pluralForm($days, ["день", "дня", "днів"]);
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $description; ?>">
    
    <meta property="og:url" content="http://www.nytimes.com/2015/02/19/arts/international/when-great-minds-dont-think-alike.html" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php echo $title; ?>" />
    <meta property="og:description" content="<?php echo $description; ?>" />
    <meta property="og:image" content="http://static01.nyt.com/images/2015/02/19/arts/international/19iht-btnumbers19A/19iht-btnumbers19A-facebookJumbo-v2.jpg" />

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
          padding-bottom: 0.5em;
          padding-top: 0.5em;
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
        Сивоху не&nbsp;били <span id="days"><?php echo $days
        ; ?></span> 
        <?php echo $text; ?></h1>
    </div>
    <div class="footer">
      <a href="https://github.com/denys-potapov/syvokho">github</a>
      <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Поширити</a></div>
      <a href="https://www.denyspotapov.com/">Денис Потапов</a>
    </div>
  </body>
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/uk_UA/sdk.js#xfbml=1&version=v6.0&appId=599480133566803&autoLogAppEvents=1"></script>
</html>
