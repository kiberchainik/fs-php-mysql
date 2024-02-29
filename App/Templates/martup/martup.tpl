<!DOCTYPE html>
<html lang="<?=$_SESSION['lang']?>">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?=$title?></title>
    <meta name="description" content="<?=$description?>" />
    <meta name="keywords" content="<?=$keywords?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta property="og:url"           content="https://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?=$title?>" />
    <meta property="og:description"   content="<?=$description?>" />
    <meta property="og:image"         content="<?=$og_img?>" />
    <meta name="DC.Title" content="<?=$title?>" />
    <meta name="DC.Subject" content="<?=$keywords?>" />
    <meta name="DC.Description" content="<?=$description?>" />
    <meta name="DC.Language" content="<?=$_SESSION['lang'].'_'.strtoupper($_SESSION['lang'])?>" />
    <link rel="canonical" href="https://<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" />
    <meta name="cryptomus" content="6f67d9d4" />
    <!-- ::::::::::::::Favicon icon::::::::::::::-->
    <link rel="apple-touch-icon" sizes="180x180" href="/Media/images/favicons/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/Media/images/favicons/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/Media/images/favicons/favicon-16x16.png" />
    <link rel="manifest" href="/Media/images/favicons/site.webmanifest" />
    <link rel="mask-icon" href="/Media/images/favicons/safari-pinned-tab.svg" color="#5bbad5" />
    <meta name="msapplication-TileColor" content="#da532c" />
    <meta name="theme-color" content="#ffffff" />
    <!-- ::::::::::::::All CSS Files here :::::::::::::: -->

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="/Media/martup/assets/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="/Media/martup/assets/css/vendor/material-icons.css" />

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="/Media/martup/assets/css/plugins/swiper-bundle.min.css" />
    <link rel="stylesheet" href="/Media/martup/assets/css/plugins/ion.rangeSlider.min.css" />
    <link rel="stylesheet" href="/Media/martup/assets/css/messenger.css" />

    <link rel="stylesheet" href="/Media/martup/assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/Media/martup/assets/css/component.css" />
    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <script src="/Media/martup/assets/js/vendor/jquery-3.6.0.min.js"></script>
    <meta name="yandex-verification" content="217d3c58b98bb61c" />
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3626047805353694"
    crossorigin="anonymous"></script>
</head>

<body>
    <?=$header?>
    <?=$content?>
    <?=$footer?>
</body>

</html>