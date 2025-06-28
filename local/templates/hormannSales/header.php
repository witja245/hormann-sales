<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$city = \Itech\Geo::getCity();
$topMenuSettings = [
    'UF_FOR_HOME_PICTURE' => \COption::GetOptionString("askaron.settings", "UF_FOR_HOME_PICTURE"),
    'UF_FOR_BUSINESS_PICTURE' => \COption::GetOptionString("askaron.settings", "UF_FOR_BUSINESS_PICTURE"),
    'UF_FOR_HOME_TEXT' => \COption::GetOptionString("askaron.settings", "UF_FOR_HOME_TEXT"),
    'UF_FOR_BUSINESS_TEXT' => \COption::GetOptionString("askaron.settings", "UF_FOR_BUSINESS_TEXT"),
    'UF_FOR_HOME_RECS' => \COption::GetOptionString("askaron.settings", "UF_FOR_HOME_RECS"),
    'UF_FOR_BUSINESS_RECS' => \COption::GetOptionString("askaron.settings", "UF_FOR_BUSINESS_RECS"),
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KVCKJJS');</script>
<!-- End Google Tag Manager -->
    <!-- <link rel="shortcut icon" href="/upload/favicon.ico" type="image/x-icon"/> -->
    <link rel="icon" type="image/png" href="/img/icon120.png">
<!--    <link rel="canonical" href="--><?//echo $APPLICATION->GetCurDir(); ?><!--"/>-->
    <meta charset="utf-8">
    <?php $APPLICATION->ShowHead() ?>
    <title><?php $APPLICATION->ShowTitle() ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta id="viewport" name="viewport" content="width=device-width">

    <meta property="og:url"
          content="<?= 'https://' . $_SERVER['HTTP_HOST'] . $APPLICATION->getCurDir() ?>"/>
    <meta property="og:site_name" content="Hormann"/>
    <meta property="og:title" content="<?php $APPLICATION->showTitle(); ?>"/>
    <meta property="og:description" content="<?php $APPLICATION->ShowProperty("description") ?>"/>
    <meta property="og:type" content="website"/>
    <!-- <meta property="og:image" content="http://hermann.itech-test.ru/upload/favicon.ico"/> -->
    <meta property="og:image" content="/img/icon120.png"/>
    <meta name="google-site-verification" content="DPrVh11C6IpJKfMqQ8GJ4AkPZVMp5DPXPbcSWK27JAs" />
	<?php
	use Bitrix\Main\Page\Asset;
	Asset::getInstance()->addCss('/static/build/css/main.css', true);
	Asset::getInstance()->addCss('/static/build/css/main.css', true);
	Asset::getInstance()->addCss('/static/build/css/main.css', true);
    Asset::getInstance()->addJs('https://www.google.com/recaptcha/api.js?render=site_key');
	?>
    <link rel="stylesheet" href="/static/build/css/main.css?v=1637848494197">
    <link rel="stylesheet" href="/local/css/custom.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="<?=DEFAULT_TEMPLATE_MAIN_PATH?>/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="<?=DEFAULT_TEMPLATE_MAIN_PATH?>/css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
      !function(n,e){"object"== typeof exports && "object" == typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define([], e) : "object" == typeof exports ? exports.device = e() : n.device = e()}(window,function(){return function(n){var e={};function o(t){if(e[t])return e[t].exports;var r=e[t]={i:t,l:!1,exports:{}};return n[t].call(r.exports,r,r.exports,o),r.l=!0,r.exports}return o.m=n,o.c=e,o.d=function(n,e,t){o.o(n,e)||Object.defineProperty(n,e,{enumerable:!0,get:t})},o.r=function(n){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(n,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(n,"__esModule",{value:!0})},o.t=function(n,e){if(1&e&&(n=o(n)),8&e)return n;if(4&e&&"object"==typeof n&&n&&n.__esModule)return n;var t=Object.create(null);if(o.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:n}),2&e&&"string"!=typeof n)for(var r in n)o.d(t,r,function(e){return n[e]}.bind(null,r));return t},o.n=function(n){var e=n&&n.__esModule?function(){return n.default}:function(){return n};return o.d(e,"a",e),e},o.o=function(n,e){return Object.prototype.hasOwnProperty.call(n,e)},o.p="",o(o.s=0)}([function(n,e,o){n.exports=o(1)},function(n,e,o){"use strict";o.r(e);var t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(n){return typeof n}:function(n){return n&&"function"==typeof Symbol&&n.constructor===Symbol&&n!==Symbol.prototype?"symbol":typeof n},r=window.device,i={},a=[];window.device=i;var c=window.document.documentElement,d=window.navigator.userAgent.toLowerCase(),u=["googletv","viera","smarttv","internet.tv","netcast","nettv","appletv","boxee","kylo","roku","dlnadoc","pov_tv","hbbtv","ce-html"];function l(n,e){return-1!==n.indexOf(e)}function s(n){return l(d,n)}function f(n){return c.className.match(new RegExp(n,"i"))}function b(n){var e=null;f(n)||(e=c.className.replace(/^\s+|\s+$/g,""),c.className=e+" "+n)}function p(n){f(n)&&(c.className=c.className.replace(" "+n,""))}function w(){i.landscape()?(p("portrait"),b("landscape"),y("landscape")):(p("landscape"),b("portrait"),y("portrait")),v()}function y(n){for(var e=0;e<a.length;e++)a[e](n)}i.macos=function(){return s("mac")},i.ios=function(){return i.iphone()||i.ipod()||i.ipad()},i.iphone=function(){return!i.windows()&&s("iphone")},i.ipod=function(){return s("ipod")},i.ipad=function(){var n="MacIntel"===navigator.platform&&navigator.maxTouchPoints>1;return s("ipad")||n},i.android=function(){return!i.windows()&&s("android")},i.androidPhone=function(){return i.android()&&s("mobile")},i.androidTablet=function(){return i.android()&&!s("mobile")},i.blackberry=function(){return s("blackberry")||s("bb10")},i.blackberryPhone=function(){return i.blackberry()&&!s("tablet")},i.blackberryTablet=function(){return i.blackberry()&&s("tablet")},i.windows=function(){return s("windows")},i.windowsPhone=function(){return i.windows()&&s("phone")},i.windowsTablet=function(){return i.windows()&&s("touch")&&!i.windowsPhone()},i.fxos=function(){return(s("(mobile")||s("(tablet"))&&s(" rv:")},i.fxosPhone=function(){return i.fxos()&&s("mobile")},i.fxosTablet=function(){return i.fxos()&&s("tablet")},i.meego=function(){return s("meego")},i.cordova=function(){return window.cordova&&"file:"===location.protocol},i.nodeWebkit=function(){return"object"===t(window.process)},i.mobile=function(){return i.androidPhone()||i.iphone()||i.ipod()||i.windowsPhone()||i.blackberryPhone()||i.fxosPhone()||i.meego()},i.tablet=function(){return i.ipad()||i.androidTablet()||i.blackberryTablet()||i.windowsTablet()||i.fxosTablet()},i.desktop=function(){return!i.tablet()&&!i.mobile()},i.television=function(){for(var n=0;n<u.length;){if(s(u[n]))return!0;n++}return!1},i.portrait=function(){return screen.orientation&&Object.prototype.hasOwnProperty.call(window,"onorientationchange")?l(screen.orientation.type,"portrait"):i.ios()&&Object.prototype.hasOwnProperty.call(window,"orientation")?90!==Math.abs(window.orientation):window.innerHeight/window.innerWidth>1},i.landscape=function(){return screen.orientation&&Object.prototype.hasOwnProperty.call(window,"onorientationchange")?l(screen.orientation.type,"landscape"):i.ios()&&Object.prototype.hasOwnProperty.call(window,"orientation")?90===Math.abs(window.orientation):window.innerHeight/window.innerWidth<1},i.noConflict=function(){return window.device=r,this},i.ios()?i.ipad()?b("ios ipad tablet"):i.iphone()?b("ios iphone mobile"):i.ipod()&&b("ios ipod mobile"):i.macos()?b("macos desktop"):i.android()?i.androidTablet()?b("android tablet"):b("android mobile"):i.blackberry()?i.blackberryTablet()?b("blackberry tablet"):b("blackberry mobile"):i.windows()?i.windowsTablet()?b("windows tablet"):i.windowsPhone()?b("windows mobile"):b("windows desktop"):i.fxos()?i.fxosTablet()?b("fxos tablet"):b("fxos mobile"):i.meego()?b("meego mobile"):i.nodeWebkit()?b("node-webkit"):i.television()?b("television"):i.desktop()&&b("desktop"),i.cordova()&&b("cordova"),i.onChangeOrientation=function(n){"function"==typeof n&&a.push(n)};var m="resize";function h(n){for(var e=0;e<n.length;e++)if(i[n[e]]())return n[e];return"unknown"}function v(){i.orientation=h(["portrait","landscape"])}Object.prototype.hasOwnProperty.call(window,"onorientationchange")&&(m="orientationchange"),window.addEventListener?window.addEventListener(m,w,!1):window.attachEvent?window.attachEvent(m,w):window[m]=w,w(),i.type=h(["mobile","tablet","desktop"]),i.os=h(["ios","iphone","ipad","ipod","android","blackberry","macos","windows","fxos","meego","television"]),v(),e.default=i}]).default});
      (function (m, a, d, vp) {var w = screen.width;if (device.ipad()) {document.getElementById(vp).setAttribute('content', 'width=' + d + ',initial-scale=' + (w / d).toFixed(2));}})(320, 1024, 1280, 'viewport');
      var appConfig = {
        'mobileVersion': false,
        'desktopVersion': true,
        'startupMessage': {
          'title': false,
          'message': false
        }
      };
    </script>
    <?php Helper::getCanonical(); ?>
<!-- calltouch -->
<script>
(function(w,d,n,c){w.CalltouchDataObject=n;w[n]=function(){w[n]["callbacks"].push(arguments)};if(!w[n]["callbacks"]){w[n]["callbacks"]=[]}w[n]["loaded"]=false;if(typeof c!=="object"){c=[c]}w[n]["counters"]=c;for(var i=0;i<c.length;i+=1){p(c[i])}function p(cId){var a=d.getElementsByTagName("script")[0],s=d.createElement("script"),i=function(){a.parentNode.insertBefore(s,a)},m=typeof Array.prototype.find === 'function',n=m?"init-min.js":"init.js";s.async=true;s.src="https://mod.calltouch.ru/"+n+"?id="+cId;if(w.opera=="[object Opera]"){d.addEventListener("DOMContentLoaded",i,false)}else{i()}}})(window,document,"ct","9z31elyk");
</script>
<!-- calltouch -->

<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "Organization",
    "address": [
        {
        "@type": "PostalAddress",
        "addressLocality": "Москва, Россия",
        "postalCode": "142701",
        "streetAddress": "Зеленое шоссе, 9"
        }
	],
    "email": "info@hormann-sales.ru",
    "name": "ООО Хёрманн Руссия",
    "telephone": "+7 (495) 604-46-21",
    "logo": "/static/build/images/logo.svg"
}
</script>

</head>
<body>
<link rel="preload" as="image" href="/upload/iblock/d2f/6qoggmfde46j2mtn8iz5pnc4wr8g88x1.webp" />
<?php $APPLICATION->ShowPanel() ?>
<div class="main">
    <header class="is-header wow <?php $APPLICATION->ShowProperty('HEADER_CLASS') ?>" data-app="header">
        <div class="is-header__inner">
            <div class="is-header__left">
                <a class="is-header__phone is-link hidden-desktop" href="tel:88005556987">
                    <? if (defined('BLACKCOLOR') && BLACKCOLOR === true): ?>
                        <svg fill="#F9AD09" height="16" viewBox="0 0 16 16" width="16"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="m.226667 2.57333 2.160003-2.159997c.15111-.151111.32889-.213333.53333-.186667.20444.026667.36889.124445.49333.293334l1.85334 2.58667c.12444.17777.17333.37777.14666.6-.02666.21333-.11555.39555-.26666.54666l-1.58667 1.57334c.90667 1.26222 1.92 2.45333 3.04 3.57333s2.30667 2.1289 3.56 3.0267l1.5867-1.5734c.1511-.1511.3377-.2355.56-.2533.2311-.0178.4311.0356.6.16l2.56 1.8133c.1689.1245.2666.2934.2933.5067.0356.2044-.0222.3822-.1733.5333l-2.1734 2.16c-.0266.0089-.0711.0134-.1333.0134-.0533 0-.1822-.0089-.3867-.0267-.2044-.0178-.4177-.0444-.64-.08-.2133-.0356-.4889-.0978-.8266-.1867-.3378-.0977-.6845-.2177-1.04-.36-.3467-.1422-.7467-.3289-1.20003-.56-.44445-.24-.89334-.5066-1.34667-.8-.45333-.3022-.94667-.6711-1.48-1.1066-.53333-.4445-1.06222-.9289-1.58667-1.4534-.65777-.6577-1.25333-1.32441-1.78666-1.99997-.52445-.68444-.94223-1.30222-1.25334-1.85333s-.57777-1.08-.799997-1.58667c-.222222-.51555-.377777-.96-.466666-1.33333-.08-.38222-.146667-.71556-.2-1-.044445-.28444-.062223-.49778-.053334-.64z"
                                  fill="#F9AD09"></path>
                        </svg>
                    <? else: ?>
                        <svg>
                            <use xlink:href="/static/build/images/sprites.svg#phone"></use>
                        </svg>
                    <? endif; ?>
                </a>
                <a class="is-header__logo"<?= $APPLICATION->GetCurPage() != "/" ? ' href="/"' : '' ?> itemprop="url">
                    <img class="responsive-img" src="/static/build/images/logo.svg" alt="logo" itemprop="logo" weight="176" height="40" >
                </a>
                <? if (defined('BLACKCOLOR') && BLACKCOLOR === true): ?>
                    <div class="is-header__location-div">
                        <a class="is-header__location is-link" href="#">
                            <svg width="11" height="15" viewBox="0 0 11 15" fill="#F9AD09" xmlns="http://www.w3.org/2000/svg">
                                <mask id="path-1-outside-1" maskUnits="userSpaceOnUse" x="0" y="0" width="11" height="15"
                                      fill="black">
                                    <rect fill="white" width="11" height="15"></rect>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M7.75786 1.61856C7.06635 1.20618 6.312 1 5.49476 1C4.88707 1 4.30559 1.12371 3.75029 1.37113C3.19499 1.61856 2.71653 1.95017 2.3149 2.36598C1.91327 2.78179 1.59371 3.26976 1.35623 3.8299C1.11874 4.39004 1 4.97251 1 5.57732C1 6.38145 1.20954 7.23711 1.62864 8.14433C1.91502 8.63918 2.24854 9.14776 2.62922 9.6701C3.0099 10.1924 3.3539 10.6323 3.66123 10.9897C3.96857 11.3471 4.28638 11.701 4.61467 12.0515C4.94296 12.4021 5.16473 12.634 5.27998 12.7474C5.39523 12.8608 5.48428 12.945 5.54715 13L6.11292 12.3608C6.49011 11.9278 6.98952 11.311 7.61118 10.5103C8.23283 9.70962 8.78463 8.93471 9.26659 8.18557C9.75553 7.20274 10 6.31616 10 5.52577C10 4.72165 9.79919 3.97251 9.39756 3.27835C8.99592 2.58419 8.44936 2.03093 7.75786 1.61856ZM5.50001 2.84619C6.1885 2.84619 6.77728 3.07192 7.26637 3.52339C7.75546 3.97486 8.00001 4.52009 8.00001 5.15909C8.00001 5.7981 7.75546 6.34159 7.26637 6.78958C6.77728 7.23758 6.1885 7.46158 5.50001 7.46158C4.81152 7.46158 4.22273 7.23758 3.73364 6.78958C3.24455 6.34159 3.00001 5.7981 3.00001 5.15909C3.00001 4.52009 3.24455 3.97486 3.73364 3.52339C4.22273 3.07192 4.81152 2.84619 5.50001 2.84619Z"></path>
                                </mask>
                                <path d="M7.75786 1.61856L7.24567 2.47743L7.75786 1.61856ZM3.75029 1.37113L4.15729 2.28456L3.75029 1.37113ZM2.3149 2.36598L3.03416 3.06072L2.3149 2.36598ZM1.35623 3.8299L0.435559 3.43955L0.435559 3.43955L1.35623 3.8299ZM1.62864 8.14433L0.720822 8.5637L0.740101 8.60543L0.763128 8.64522L1.62864 8.14433ZM2.62922 9.6701L3.43737 9.08113H3.43737L2.62922 9.6701ZM3.66123 10.9897L2.90303 11.6417L2.90303 11.6417L3.66123 10.9897ZM4.61467 12.0515L5.34454 11.368L5.34454 11.368L4.61467 12.0515ZM5.27998 12.7474L4.57861 13.4602L4.57861 13.4602L5.27998 12.7474ZM5.54715 13L4.8888 13.7527L5.63706 14.4072L6.29594 13.6628L5.54715 13ZM6.11292 12.3608L6.86174 13.0236L6.86695 13.0177L6.11292 12.3608ZM7.61118 10.5103L6.8213 9.89705L6.8213 9.89705L7.61118 10.5103ZM9.26659 8.18557L10.1076 8.72662L10.1374 8.68029L10.1619 8.63098L9.26659 8.18557ZM9.39756 3.27835L10.2631 2.77755V2.77755L9.39756 3.27835ZM7.26637 3.52339L6.58809 4.2582V4.2582L7.26637 3.52339ZM7.26637 6.78958L6.59092 6.05218L6.59092 6.05218L7.26637 6.78958ZM3.73364 3.52339L3.05536 2.78859L3.05536 2.78859L3.73364 3.52339ZM5.49476 2C6.13452 2 6.71148 2.15887 7.24567 2.47743L8.27004 0.759681C7.42122 0.253495 6.48947 0 5.49476 0V2ZM4.15729 2.28456C4.58454 2.09419 5.02737 2 5.49476 2V0C4.74678 0 4.02664 0.153229 3.3433 0.457704L4.15729 2.28456ZM3.03416 3.06072C3.34214 2.74187 3.713 2.48252 4.15729 2.28456L3.3433 0.457704C2.67698 0.754593 2.09092 1.15847 1.59564 1.67124L3.03416 3.06072ZM2.2769 4.22024C2.46903 3.76707 2.72218 3.38371 3.03416 3.06072L1.59564 1.67124C1.10436 2.17987 0.718397 2.77245 0.435559 3.43955L2.2769 4.22024ZM2 5.57732C2 5.10744 2.09144 4.65766 2.2769 4.22024L0.435559 3.43955C0.14604 4.12242 0 4.83757 0 5.57732H2ZM2.53645 7.72496C2.16374 6.91813 2 6.20592 2 5.57732H0C0 6.55698 0.255352 7.55609 0.720822 8.5637L2.53645 7.72496ZM3.43737 9.08113C3.07473 8.58354 2.76088 8.10433 2.49415 7.64344L0.763128 8.64522C1.06916 9.17403 1.42235 9.71199 1.82107 10.2591L3.43737 9.08113ZM4.41944 10.3377C4.13464 10.0065 3.80759 9.58912 3.43737 9.08113L1.82107 10.2591C2.2122 10.7958 2.57315 11.2581 2.90303 11.6417L4.41944 10.3377ZM5.34454 11.368C5.02573 11.0276 4.71738 10.6841 4.41944 10.3377L2.90303 11.6417C3.21976 12.01 3.54702 12.3745 3.8848 12.7351L5.34454 11.368ZM5.98135 12.0346C5.88303 11.9379 5.67505 11.7208 5.34454 11.368L3.8848 12.7351C4.21087 13.0833 4.44642 13.3302 4.57861 13.4602L5.98135 12.0346ZM6.2055 12.2473C6.16526 12.2121 6.09297 12.1445 5.98134 12.0346L4.57861 13.4602C4.69749 13.5772 4.80331 13.6779 4.8888 13.7527L6.2055 12.2473ZM5.36413 11.698L4.79835 12.3372L6.29594 13.6628L6.86172 13.0236L5.36413 11.698ZM6.8213 9.89705C6.20391 10.6922 5.71782 11.2919 5.35889 11.704L6.86695 13.0177C7.26239 12.5637 7.77514 11.9298 8.40106 11.1236L6.8213 9.89705ZM8.4256 7.64452C7.9616 8.36575 7.42727 9.11655 6.8213 9.89705L8.40106 11.1236C9.03839 10.3027 9.60766 9.50368 10.1076 8.72662L8.4256 7.64452ZM9 5.52577C9 6.11349 8.81658 6.84503 8.37126 7.74015L10.1619 8.63098C10.6945 7.56046 11 6.51882 11 5.52577H9ZM8.53199 3.77915C8.84531 4.32067 9 4.897 9 5.52577H11C11 4.54629 10.7531 3.62435 10.2631 2.77755L8.53199 3.77915ZM7.24567 2.47743C7.7914 2.80287 8.21607 3.23312 8.53199 3.77915L10.2631 2.77755C9.77578 1.93526 9.10732 1.25899 8.27004 0.759681L7.24567 2.47743ZM7.94465 2.78859C7.26395 2.16025 6.43035 1.84619 5.50001 1.84619V3.84619C5.94665 3.84619 6.29061 3.9836 6.58809 4.2582L7.94465 2.78859ZM9.00001 5.15909C9.00001 4.22813 8.62918 3.42046 7.94465 2.78859L6.58809 4.2582C6.88175 4.52926 7.00001 4.81205 7.00001 5.15909H9.00001ZM7.94182 7.52699C8.62882 6.89772 9.00001 6.09036 9.00001 5.15909H7.00001C7.00001 5.50583 6.88211 5.78546 6.59092 6.05218L7.94182 7.52699ZM5.50001 8.46158C6.42808 8.46158 7.26075 8.15084 7.94182 7.52699L6.59092 6.05218C6.29381 6.32432 5.94891 6.46158 5.50001 6.46158V8.46158ZM3.05819 7.52699C3.73927 8.15084 4.57193 8.46158 5.50001 8.46158V6.46158C5.0511 6.46158 4.7062 6.32432 4.40909 6.05218L3.05819 7.52699ZM2.00001 5.15909C2.00001 6.09036 2.37119 6.89772 3.05819 7.52699L4.40909 6.05218C4.11791 5.78546 4.00001 5.50583 4.00001 5.15909H2.00001ZM3.05536 2.78859C2.37083 3.42046 2.00001 4.22813 2.00001 5.15909H4.00001C4.00001 4.81205 4.11826 4.52926 4.41192 4.2582L3.05536 2.78859ZM5.50001 1.84619C4.56966 1.84619 3.73607 2.16025 3.05536 2.78859L4.41192 4.2582C4.7094 3.9836 5.05337 3.84619 5.50001 3.84619V1.84619Z"
                                      fill="#F9AD09" mask="url(#path-1-outside-1)"></path>
                            </svg>
                            <span><?=$city['NAME']?></span>
                        </a>
                    </div>
                <? else: ?>
                    <div class="is-header__location-div">
                        <a class="is-header__location is-link" href="#">
                            <svg width="11" height="15" viewBox="0 0 11 15" fill="#F9AD09" xmlns="http://www.w3.org/2000/svg">
                                <mask id="path-1-outside-1" maskUnits="userSpaceOnUse" x="0" y="0" width="11" height="15"
                                      fill="black">
                                    <rect fill="white" width="11" height="15"></rect>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M7.75786 1.61856C7.06635 1.20618 6.312 1 5.49476 1C4.88707 1 4.30559 1.12371 3.75029 1.37113C3.19499 1.61856 2.71653 1.95017 2.3149 2.36598C1.91327 2.78179 1.59371 3.26976 1.35623 3.8299C1.11874 4.39004 1 4.97251 1 5.57732C1 6.38145 1.20954 7.23711 1.62864 8.14433C1.91502 8.63918 2.24854 9.14776 2.62922 9.6701C3.0099 10.1924 3.3539 10.6323 3.66123 10.9897C3.96857 11.3471 4.28638 11.701 4.61467 12.0515C4.94296 12.4021 5.16473 12.634 5.27998 12.7474C5.39523 12.8608 5.48428 12.945 5.54715 13L6.11292 12.3608C6.49011 11.9278 6.98952 11.311 7.61118 10.5103C8.23283 9.70962 8.78463 8.93471 9.26659 8.18557C9.75553 7.20274 10 6.31616 10 5.52577C10 4.72165 9.79919 3.97251 9.39756 3.27835C8.99592 2.58419 8.44936 2.03093 7.75786 1.61856ZM5.50001 2.84619C6.1885 2.84619 6.77728 3.07192 7.26637 3.52339C7.75546 3.97486 8.00001 4.52009 8.00001 5.15909C8.00001 5.7981 7.75546 6.34159 7.26637 6.78958C6.77728 7.23758 6.1885 7.46158 5.50001 7.46158C4.81152 7.46158 4.22273 7.23758 3.73364 6.78958C3.24455 6.34159 3.00001 5.7981 3.00001 5.15909C3.00001 4.52009 3.24455 3.97486 3.73364 3.52339C4.22273 3.07192 4.81152 2.84619 5.50001 2.84619Z"></path>
                                </mask>
                                <path d="M7.75786 1.61856L7.24567 2.47743L7.75786 1.61856ZM3.75029 1.37113L4.15729 2.28456L3.75029 1.37113ZM2.3149 2.36598L3.03416 3.06072L2.3149 2.36598ZM1.35623 3.8299L0.435559 3.43955L0.435559 3.43955L1.35623 3.8299ZM1.62864 8.14433L0.720822 8.5637L0.740101 8.60543L0.763128 8.64522L1.62864 8.14433ZM2.62922 9.6701L3.43737 9.08113H3.43737L2.62922 9.6701ZM3.66123 10.9897L2.90303 11.6417L2.90303 11.6417L3.66123 10.9897ZM4.61467 12.0515L5.34454 11.368L5.34454 11.368L4.61467 12.0515ZM5.27998 12.7474L4.57861 13.4602L4.57861 13.4602L5.27998 12.7474ZM5.54715 13L4.8888 13.7527L5.63706 14.4072L6.29594 13.6628L5.54715 13ZM6.11292 12.3608L6.86174 13.0236L6.86695 13.0177L6.11292 12.3608ZM7.61118 10.5103L6.8213 9.89705L6.8213 9.89705L7.61118 10.5103ZM9.26659 8.18557L10.1076 8.72662L10.1374 8.68029L10.1619 8.63098L9.26659 8.18557ZM9.39756 3.27835L10.2631 2.77755V2.77755L9.39756 3.27835ZM7.26637 3.52339L6.58809 4.2582V4.2582L7.26637 3.52339ZM7.26637 6.78958L6.59092 6.05218L6.59092 6.05218L7.26637 6.78958ZM3.73364 3.52339L3.05536 2.78859L3.05536 2.78859L3.73364 3.52339ZM5.49476 2C6.13452 2 6.71148 2.15887 7.24567 2.47743L8.27004 0.759681C7.42122 0.253495 6.48947 0 5.49476 0V2ZM4.15729 2.28456C4.58454 2.09419 5.02737 2 5.49476 2V0C4.74678 0 4.02664 0.153229 3.3433 0.457704L4.15729 2.28456ZM3.03416 3.06072C3.34214 2.74187 3.713 2.48252 4.15729 2.28456L3.3433 0.457704C2.67698 0.754593 2.09092 1.15847 1.59564 1.67124L3.03416 3.06072ZM2.2769 4.22024C2.46903 3.76707 2.72218 3.38371 3.03416 3.06072L1.59564 1.67124C1.10436 2.17987 0.718397 2.77245 0.435559 3.43955L2.2769 4.22024ZM2 5.57732C2 5.10744 2.09144 4.65766 2.2769 4.22024L0.435559 3.43955C0.14604 4.12242 0 4.83757 0 5.57732H2ZM2.53645 7.72496C2.16374 6.91813 2 6.20592 2 5.57732H0C0 6.55698 0.255352 7.55609 0.720822 8.5637L2.53645 7.72496ZM3.43737 9.08113C3.07473 8.58354 2.76088 8.10433 2.49415 7.64344L0.763128 8.64522C1.06916 9.17403 1.42235 9.71199 1.82107 10.2591L3.43737 9.08113ZM4.41944 10.3377C4.13464 10.0065 3.80759 9.58912 3.43737 9.08113L1.82107 10.2591C2.2122 10.7958 2.57315 11.2581 2.90303 11.6417L4.41944 10.3377ZM5.34454 11.368C5.02573 11.0276 4.71738 10.6841 4.41944 10.3377L2.90303 11.6417C3.21976 12.01 3.54702 12.3745 3.8848 12.7351L5.34454 11.368ZM5.98135 12.0346C5.88303 11.9379 5.67505 11.7208 5.34454 11.368L3.8848 12.7351C4.21087 13.0833 4.44642 13.3302 4.57861 13.4602L5.98135 12.0346ZM6.2055 12.2473C6.16526 12.2121 6.09297 12.1445 5.98134 12.0346L4.57861 13.4602C4.69749 13.5772 4.80331 13.6779 4.8888 13.7527L6.2055 12.2473ZM5.36413 11.698L4.79835 12.3372L6.29594 13.6628L6.86172 13.0236L5.36413 11.698ZM6.8213 9.89705C6.20391 10.6922 5.71782 11.2919 5.35889 11.704L6.86695 13.0177C7.26239 12.5637 7.77514 11.9298 8.40106 11.1236L6.8213 9.89705ZM8.4256 7.64452C7.9616 8.36575 7.42727 9.11655 6.8213 9.89705L8.40106 11.1236C9.03839 10.3027 9.60766 9.50368 10.1076 8.72662L8.4256 7.64452ZM9 5.52577C9 6.11349 8.81658 6.84503 8.37126 7.74015L10.1619 8.63098C10.6945 7.56046 11 6.51882 11 5.52577H9ZM8.53199 3.77915C8.84531 4.32067 9 4.897 9 5.52577H11C11 4.54629 10.7531 3.62435 10.2631 2.77755L8.53199 3.77915ZM7.24567 2.47743C7.7914 2.80287 8.21607 3.23312 8.53199 3.77915L10.2631 2.77755C9.77578 1.93526 9.10732 1.25899 8.27004 0.759681L7.24567 2.47743ZM7.94465 2.78859C7.26395 2.16025 6.43035 1.84619 5.50001 1.84619V3.84619C5.94665 3.84619 6.29061 3.9836 6.58809 4.2582L7.94465 2.78859ZM9.00001 5.15909C9.00001 4.22813 8.62918 3.42046 7.94465 2.78859L6.58809 4.2582C6.88175 4.52926 7.00001 4.81205 7.00001 5.15909H9.00001ZM7.94182 7.52699C8.62882 6.89772 9.00001 6.09036 9.00001 5.15909H7.00001C7.00001 5.50583 6.88211 5.78546 6.59092 6.05218L7.94182 7.52699ZM5.50001 8.46158C6.42808 8.46158 7.26075 8.15084 7.94182 7.52699L6.59092 6.05218C6.29381 6.32432 5.94891 6.46158 5.50001 6.46158V8.46158ZM3.05819 7.52699C3.73927 8.15084 4.57193 8.46158 5.50001 8.46158V6.46158C5.0511 6.46158 4.7062 6.32432 4.40909 6.05218L3.05819 7.52699ZM2.00001 5.15909C2.00001 6.09036 2.37119 6.89772 3.05819 7.52699L4.40909 6.05218C4.11791 5.78546 4.00001 5.50583 4.00001 5.15909H2.00001ZM3.05536 2.78859C2.37083 3.42046 2.00001 4.22813 2.00001 5.15909H4.00001C4.00001 4.81205 4.11826 4.52926 4.41192 4.2582L3.05536 2.78859ZM5.50001 1.84619C4.56966 1.84619 3.73607 2.16025 3.05536 2.78859L4.41192 4.2582C4.7094 3.9836 5.05337 3.84619 5.50001 3.84619V1.84619Z"
                                      fill="#F9AD09" mask="url(#path-1-outside-1)"></path>
                            </svg>
                            <span><?= $city['NAME'] ?></span>
                        </a>
                    </div>
                <? endif; ?>
                <div class="is-header__location__drop hidden-mobile">
                    <div class="is-header__location__drop__name">Ваш город: <span><?= $city['NAME'] ?></span>
                        <? if (!$_COOKIE['user_city']['NAME']) {
                            echo ' (определено автоматически)';
                        } ?>
                    </div>
                    <div class="is-header__location__drop__btns">
                        <button class="is-header__location__drop__btns__yes" type="button">Да, верно</button>
                        <button class="is-header__location__drop__btns__no" type="button" data-src="#geo" data-fancybox>
                            Нет, изменить
                        </button>
                    </div>
                </div>
            </div>
            <div class="is-header__right">
                <div class="is-header__phone-div">
                    <a class="is-header__phone is-link hidden-mobile"
                       href="tel:<?= \COption::GetOptionString("askaron.settings", "UF_PHONE")[0] ?>">
                        <? if (defined('BLACKCOLOR') && BLACKCOLOR === true): ?>
                            <svg fill="#F9AD09" height="16" viewBox="0 0 16 16" width="16"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="m.226667 2.57333 2.160003-2.159997c.15111-.151111.32889-.213333.53333-.186667.20444.026667.36889.124445.49333.293334l1.85334 2.58667c.12444.17777.17333.37777.14666.6-.02666.21333-.11555.39555-.26666.54666l-1.58667 1.57334c.90667 1.26222 1.92 2.45333 3.04 3.57333s2.30667 2.1289 3.56 3.0267l1.5867-1.5734c.1511-.1511.3377-.2355.56-.2533.2311-.0178.4311.0356.6.16l2.56 1.8133c.1689.1245.2666.2934.2933.5067.0356.2044-.0222.3822-.1733.5333l-2.1734 2.16c-.0266.0089-.0711.0134-.1333.0134-.0533 0-.1822-.0089-.3867-.0267-.2044-.0178-.4177-.0444-.64-.08-.2133-.0356-.4889-.0978-.8266-.1867-.3378-.0977-.6845-.2177-1.04-.36-.3467-.1422-.7467-.3289-1.20003-.56-.44445-.24-.89334-.5066-1.34667-.8-.45333-.3022-.94667-.6711-1.48-1.1066-.53333-.4445-1.06222-.9289-1.58667-1.4534-.65777-.6577-1.25333-1.32441-1.78666-1.99997-.52445-.68444-.94223-1.30222-1.25334-1.85333s-.57777-1.08-.799997-1.58667c-.222222-.51555-.377777-.96-.466666-1.33333-.08-.38222-.146667-.71556-.2-1-.044445-.28444-.062223-.49778-.053334-.64z"
                                      fill="#F9AD09"></path>
                            </svg>
                        <? else: ?>
                            <svg fill="#F9AD09" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
                                <path d="m.226667 2.57333 2.160003-2.159997c.15111-.151111.32889-.213333.53333-.186667.20444.026667.36889.124445.49333.293334l1.85334 2.58667c.12444.17777.17333.37777.14666.6-.02666.21333-.11555.39555-.26666.54666l-1.58667 1.57334c.90667 1.26222 1.92 2.45333 3.04 3.57333s2.30667 2.1289 3.56 3.0267l1.5867-1.5734c.1511-.1511.3377-.2355.56-.2533.2311-.0178.4311.0356.6.16l2.56 1.8133c.1689.1245.2666.2934.2933.5067.0356.2044-.0222.3822-.1733.5333l-2.1734 2.16c-.0266.0089-.0711.0134-.1333.0134-.0533 0-.1822-.0089-.3867-.0267-.2044-.0178-.4177-.0444-.64-.08-.2133-.0356-.4889-.0978-.8266-.1867-.3378-.0977-.6845-.2177-1.04-.36-.3467-.1422-.7467-.3289-1.20003-.56-.44445-.24-.89334-.5066-1.34667-.8-.45333-.3022-.94667-.6711-1.48-1.1066-.53333-.4445-1.06222-.9289-1.58667-1.4534-.65777-.6577-1.25333-1.32441-1.78666-1.99997-.52445-.68444-.94223-1.30222-1.25334-1.85333s-.57777-1.08-.799997-1.58667c-.222222-.51555-.377777-.96-.466666-1.33333-.08-.38222-.146667-.71556-.2-1-.044445-.28444-.062223-.49778-.053334-.64z"
                                      fill="#F9AD09"></path>
                            </svg>
                        <? endif; ?>
                        <span><?= \COption::GetOptionString("askaron.settings", "UF_PHONE")[1] ?></span>
                    </a>
                </div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "top.menu",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(""),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "top",
                        "USE_EXT" => "N",
                        'SETTINGS' => $topMenuSettings,
                    )
                ); ?>
                <span class="is-header__menu-btn" role="button" rel="nofollow" aria-haspopup="true"
                      aria-expanded="false" data-gclick="toggleMenu">
                    <span class="burger" id="burger-icon">
                        <span class="line line-1"></span>
                        <span class="line line-2"></span>
                        <span class="line line-3"></span>
                    </span>
                </span>
            </div>
        </div>
    </header>

    <div class="dd-menu" id="ddMenu">
        <button class="dd-menu__close button" title="Закрыть" data-gclick="toggleMenu">
            <svg width="22" height="17" viewBox="0 0 22 17" xmlns="http://www.w3.org/2000/svg">
                <rect x="2.86829" y="15.9246" width="22" height="1" transform="rotate(-45 2.86829 15.9246)"
                      fill="#797C80"></rect>
                <rect x="3.57538" y="0.368164" width="22" height="1" transform="rotate(45 3.57538 0.368164)"
                      fill="#797C80"></rect>
            </svg>
        </button>
        <div class="dd-menu__scrollable-area">
            <? $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "right.menu",
                array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "left",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(""),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "right",
                    "USE_EXT" => "N",
                )
            ); ?>
            <div class="dd-menu__search">
                <form action="/search/" method="get">
                    <input class="is-input" name="q" type="text" placeholder="Поиск по сайту">
                    <button class="button dd-menu__search-submit" type="submit" title="Отправить">
                        <svg fill="none" height="18" viewBox="0 0 18 18" width="18" xmlns="http://www.w3.org/2000/svg">
                            <g stroke="#616366" stroke-linecap="round" stroke-linejoin="round"
                               stroke-width="/static/build888889">
                                <path clip-rule="evenodd"
                                      d="m7.66667 14.3333c3.68193 0 6.66663-2.9847 6.66663-6.66663 0-3.6819-2.9847-6.66667-6.66663-6.66667-3.6819 0-6.66667 2.98477-6.66667 6.66667 0 3.68193 2.98477 6.66663 6.66667 6.66663z"
                                      fill-rule="evenodd"></path>
                                <path d="m17 16.9999-4.6222-4.6222"></path>
                            </g>
                        </svg>
                    </button>
                </form>
            </div>
            <div class="dd-menu__contact">
                <div class="dd-menu__info">
                    <ul>
                        <li><a href="#">
                                <svg>
                                    <use xlink:href="/static/build/images/sprites.svg#letter"></use>
                                </svg>
                                <span>info@hoermann.ru</span></a></li>
                        <li><a href="#">
                                <svg>
                                    <use xlink:href="/static/build/images/sprites.svg#point"></use>
                                </svg>
                                <span>Задать вопрос</span></a></li>
                    </ul>
                </div>
                <div class="dd-menu__social">
                    <ul>
                        <li><a href="#">
                                <svg>
                                    <use xlink:href="/static/build/images/sprites.svg#vk"></use>
                                </svg>
                            </a></li>
                        <li><a href="#">
                                <svg>
                                    <use xlink:href="/static/build/images/sprites.svg#facebook"></use>
                                </svg>
                            </a></li>
                        <li><a href="#">
                                <svg>
                                    <use xlink:href="/static/build/images/sprites.svg#instagram"></use>
                                </svg>
                            </a></li>
                        <li><a href="#">
                                <svg>
                                    <use xlink:href="/static/build/images/sprites.svg#youtube"></use>
                                </svg>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    