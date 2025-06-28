<!DOCTYPE html>

<html lang="ru">

<head>
    <meta charset="utf-8" />

    <title>Project title</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" id="viewport" content="width=device-width">
    <meta name="cmsmagazine" content="9fd15f69c95385763dcf768ea3b67e22" />
    <meta name="theme-color" content="#3e4046" />

    <meta property="og:url" content="<? /* http://domain.com/path/to/page/ */ ?>" />
    <meta property="og:site_name" content="<? /* Site name */ ?>" />
    <meta property="og:title" content="<? /* title */ ?>" />
    <meta property="og:description" content="<? /* description */ ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<? /* http://domain.com/path/to/image.png */ ?>" />

    <link rel="apple-touch-icon" sizes="32x32" href="/img/icon32.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="/img/icon72.png"/>
    <link rel="shortcut icon" type="image/png" href="/img/favicon.ico"/>
    
    <link rel="stylesheet" href="css/vendor.min.css?nocache=<?=rand()?>" />
    <link rel="stylesheet" href="css/app.min.css?nocache=<?=rand()?>" />

    <!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->

    <script>
        var appConfig = {
            'mobileVersion':false,
            'desktopVersion':true,
            'startupMessage':{
                'title':false,
                'message':false
            }
        };
        (function(){var a,b,c,d,e,f,g,h,i,j;a=window.device,window.device={},c=window.document.documentElement,j=window.navigator.userAgent.toLowerCase(),device.ios=function(){return device.iphone()||device.ipod()||device.ipad()},device.iphone=function(){return d("iphone")},device.ipod=function(){return d("ipod")},device.ipad=function(){return d("ipad")},device.android=function(){return d("android")},device.androidPhone=function(){return device.android()&&d("mobile")},device.androidTablet=function(){return device.android()&&!d("mobile")},device.blackberry=function(){return d("blackberry")||d("bb10")||d("rim")},device.blackberryPhone=function(){return device.blackberry()&&!d("tablet")},device.blackberryTablet=function(){return device.blackberry()&&d("tablet")},device.windows=function(){return d("windows")},device.windowsPhone=function(){return device.windows()&&d("phone")},device.windowsTablet=function(){return device.windows()&&d("touch")&&!device.windowsPhone()},device.fxos=function(){return(d("(mobile;")||d("(tablet;"))&&d("; rv:")},device.fxosPhone=function(){return device.fxos()&&d("mobile")},device.fxosTablet=function(){return device.fxos()&&d("tablet")},device.meego=function(){return d("meego")},device.cordova=function(){return window.cordova&&"file:"===location.protocol},device.nodeWebkit=function(){return"object"==typeof window.process},device.mobile=function(){return device.androidPhone()||device.iphone()||device.ipod()||device.windowsPhone()||device.blackberryPhone()||device.fxosPhone()||device.meego()},device.tablet=function(){return device.ipad()||device.androidTablet()||device.blackberryTablet()||device.windowsTablet()||device.fxosTablet()},device.desktop=function(){return!device.tablet()&&!device.mobile()},device.portrait=function(){return window.innerHeight/window.innerWidth>1},device.landscape=function(){return window.innerHeight/window.innerWidth<1},device.noConflict=function(){return window.device=a,this},d=function(a){return-1!==j.indexOf(a)},f=function(a){var b;return b=new RegExp(a,"i"),c.className.match(b)},b=function(a){return f(a)?void 0:c.className+=" "+a},h=function(a){return f(a)?c.className=c.className.replace(a,""):void 0},device.ios()?device.ipad()?b("ios ipad tablet"):device.iphone()?b("ios iphone mobile"):device.ipod()&&b("ios ipod mobile"):b(device.android()?device.androidTablet()?"android tablet":"android mobile":device.blackberry()?device.blackberryTablet()?"blackberry tablet":"blackberry mobile":device.windows()?device.windowsTablet()?"windows tablet":device.windowsPhone()?"windows mobile":"desktop":device.fxos()?device.fxosTablet()?"fxos tablet":"fxos mobile":device.meego()?"meego mobile":device.nodeWebkit()?"node-webkit":"desktop"),device.cordova()&&b("cordova"),e=function(){return device.landscape()?(h("portrait"),b("landscape")):(h("landscape"),b("portrait"))},i="onorientationchange"in window,g=i?"orientationchange":"resize",window.addEventListener?window.addEventListener(g,e,!1):window.attachEvent?window.attachEvent(g,e):window[g]=e,e()}).call(this);
        (function(a,d,vp){
            var w=screen.width,h=screen.height;
            if (w<a || h<a || device.mobile()) {
                appConfig.mobileVersion = true;
            } else {
                document.getElementById(vp).setAttribute('content','width='+d);
            }
            appConfig.desktopVersion = !appConfig.mobileVersion;
        })(768,1366,'viewport');
    </script>
</head>

<? $curPage = ""; ?>

<body id="body" class="body-bg">
  <div style="display:none;">
    <?php include('svgs.php'); ?>
  </div>
  <script>
    (function(b,c){
      if (appConfig.mobileVersion) { return false; }
      var el = document.getElementById(b);
      if (el.classList) { el.classList.add(c); }
      else { el.className += ' ' + c; }
    })('body','jsfx');
  </script>

  <div class="loader">
    <div class="loader_inner"></div>
  </div>

  <header class="is-header header-homepage">
              
    <div class="is-header__inner">
      <div class="is-header__left">
        <a href="#" class="is-header__logo">
          <img src="/img/logo.svg" alt="" class="responsive-img">
        </a>
        <a href="#" class="is-header__location is-link">
          <svg width="11" height="15" viewBox="0 0 11 15" fill="#fff" xmlns="http://www.w3.org/2000/svg">
            <mask id="path-1-outside-1" maskUnits="userSpaceOnUse" x="0" y="0" width="11" height="15" fill="black">
              <rect fill="white" width="11" height="15" />
              <path fill-rule="evenodd" clip-rule="evenodd" d="M7.75786 1.61856C7.06635 1.20618 6.312 1 5.49476 1C4.88707 1 4.30559 1.12371 3.75029 1.37113C3.19499 1.61856 2.71653 1.95017 2.3149 2.36598C1.91327 2.78179 1.59371 3.26976 1.35623 3.8299C1.11874 4.39004 1 4.97251 1 5.57732C1 6.38145 1.20954 7.23711 1.62864 8.14433C1.91502 8.63918 2.24854 9.14776 2.62922 9.6701C3.0099 10.1924 3.3539 10.6323 3.66123 10.9897C3.96857 11.3471 4.28638 11.701 4.61467 12.0515C4.94296 12.4021 5.16473 12.634 5.27998 12.7474C5.39523 12.8608 5.48428 12.945 5.54715 13L6.11292 12.3608C6.49011 11.9278 6.98952 11.311 7.61118 10.5103C8.23283 9.70962 8.78463 8.93471 9.26659 8.18557C9.75553 7.20274 10 6.31616 10 5.52577C10 4.72165 9.79919 3.97251 9.39756 3.27835C8.99592 2.58419 8.44936 2.03093 7.75786 1.61856ZM5.50001 2.84619C6.1885 2.84619 6.77728 3.07192 7.26637 3.52339C7.75546 3.97486 8.00001 4.52009 8.00001 5.15909C8.00001 5.7981 7.75546 6.34159 7.26637 6.78958C6.77728 7.23758 6.1885 7.46158 5.50001 7.46158C4.81152 7.46158 4.22273 7.23758 3.73364 6.78958C3.24455 6.34159 3.00001 5.7981 3.00001 5.15909C3.00001 4.52009 3.24455 3.97486 3.73364 3.52339C4.22273 3.07192 4.81152 2.84619 5.50001 2.84619Z" />
            </mask>
            <path d="M7.75786 1.61856L7.24567 2.47743L7.75786 1.61856ZM3.75029 1.37113L4.15729 2.28456L3.75029 1.37113ZM2.3149 2.36598L3.03416 3.06072L2.3149 2.36598ZM1.35623 3.8299L0.435559 3.43955L0.435559 3.43955L1.35623 3.8299ZM1.62864 8.14433L0.720822 8.5637L0.740101 8.60543L0.763128 8.64522L1.62864 8.14433ZM2.62922 9.6701L3.43737 9.08113H3.43737L2.62922 9.6701ZM3.66123 10.9897L2.90303 11.6417L2.90303 11.6417L3.66123 10.9897ZM4.61467 12.0515L5.34454 11.368L5.34454 11.368L4.61467 12.0515ZM5.27998 12.7474L4.57861 13.4602L4.57861 13.4602L5.27998 12.7474ZM5.54715 13L4.8888 13.7527L5.63706 14.4072L6.29594 13.6628L5.54715 13ZM6.11292 12.3608L6.86174 13.0236L6.86695 13.0177L6.11292 12.3608ZM7.61118 10.5103L6.8213 9.89705L6.8213 9.89705L7.61118 10.5103ZM9.26659 8.18557L10.1076 8.72662L10.1374 8.68029L10.1619 8.63098L9.26659 8.18557ZM9.39756 3.27835L10.2631 2.77755V2.77755L9.39756 3.27835ZM7.26637 3.52339L6.58809 4.2582V4.2582L7.26637 3.52339ZM7.26637 6.78958L6.59092 6.05218L6.59092 6.05218L7.26637 6.78958ZM3.73364 3.52339L3.05536 2.78859L3.05536 2.78859L3.73364 3.52339ZM5.49476 2C6.13452 2 6.71148 2.15887 7.24567 2.47743L8.27004 0.759681C7.42122 0.253495 6.48947 0 5.49476 0V2ZM4.15729 2.28456C4.58454 2.09419 5.02737 2 5.49476 2V0C4.74678 0 4.02664 0.153229 3.3433 0.457704L4.15729 2.28456ZM3.03416 3.06072C3.34214 2.74187 3.713 2.48252 4.15729 2.28456L3.3433 0.457704C2.67698 0.754593 2.09092 1.15847 1.59564 1.67124L3.03416 3.06072ZM2.2769 4.22024C2.46903 3.76707 2.72218 3.38371 3.03416 3.06072L1.59564 1.67124C1.10436 2.17987 0.718397 2.77245 0.435559 3.43955L2.2769 4.22024ZM2 5.57732C2 5.10744 2.09144 4.65766 2.2769 4.22024L0.435559 3.43955C0.14604 4.12242 0 4.83757 0 5.57732H2ZM2.53645 7.72496C2.16374 6.91813 2 6.20592 2 5.57732H0C0 6.55698 0.255352 7.55609 0.720822 8.5637L2.53645 7.72496ZM3.43737 9.08113C3.07473 8.58354 2.76088 8.10433 2.49415 7.64344L0.763128 8.64522C1.06916 9.17403 1.42235 9.71199 1.82107 10.2591L3.43737 9.08113ZM4.41944 10.3377C4.13464 10.0065 3.80759 9.58912 3.43737 9.08113L1.82107 10.2591C2.2122 10.7958 2.57315 11.2581 2.90303 11.6417L4.41944 10.3377ZM5.34454 11.368C5.02573 11.0276 4.71738 10.6841 4.41944 10.3377L2.90303 11.6417C3.21976 12.01 3.54702 12.3745 3.8848 12.7351L5.34454 11.368ZM5.98135 12.0346C5.88303 11.9379 5.67505 11.7208 5.34454 11.368L3.8848 12.7351C4.21087 13.0833 4.44642 13.3302 4.57861 13.4602L5.98135 12.0346ZM6.2055 12.2473C6.16526 12.2121 6.09297 12.1445 5.98134 12.0346L4.57861 13.4602C4.69749 13.5772 4.80331 13.6779 4.8888 13.7527L6.2055 12.2473ZM5.36413 11.698L4.79835 12.3372L6.29594 13.6628L6.86172 13.0236L5.36413 11.698ZM6.8213 9.89705C6.20391 10.6922 5.71782 11.2919 5.35889 11.704L6.86695 13.0177C7.26239 12.5637 7.77514 11.9298 8.40106 11.1236L6.8213 9.89705ZM8.4256 7.64452C7.9616 8.36575 7.42727 9.11655 6.8213 9.89705L8.40106 11.1236C9.03839 10.3027 9.60766 9.50368 10.1076 8.72662L8.4256 7.64452ZM9 5.52577C9 6.11349 8.81658 6.84503 8.37126 7.74015L10.1619 8.63098C10.6945 7.56046 11 6.51882 11 5.52577H9ZM8.53199 3.77915C8.84531 4.32067 9 4.897 9 5.52577H11C11 4.54629 10.7531 3.62435 10.2631 2.77755L8.53199 3.77915ZM7.24567 2.47743C7.7914 2.80287 8.21607 3.23312 8.53199 3.77915L10.2631 2.77755C9.77578 1.93526 9.10732 1.25899 8.27004 0.759681L7.24567 2.47743ZM7.94465 2.78859C7.26395 2.16025 6.43035 1.84619 5.50001 1.84619V3.84619C5.94665 3.84619 6.29061 3.9836 6.58809 4.2582L7.94465 2.78859ZM9.00001 5.15909C9.00001 4.22813 8.62918 3.42046 7.94465 2.78859L6.58809 4.2582C6.88175 4.52926 7.00001 4.81205 7.00001 5.15909H9.00001ZM7.94182 7.52699C8.62882 6.89772 9.00001 6.09036 9.00001 5.15909H7.00001C7.00001 5.50583 6.88211 5.78546 6.59092 6.05218L7.94182 7.52699ZM5.50001 8.46158C6.42808 8.46158 7.26075 8.15084 7.94182 7.52699L6.59092 6.05218C6.29381 6.32432 5.94891 6.46158 5.50001 6.46158V8.46158ZM3.05819 7.52699C3.73927 8.15084 4.57193 8.46158 5.50001 8.46158V6.46158C5.0511 6.46158 4.7062 6.32432 4.40909 6.05218L3.05819 7.52699ZM2.00001 5.15909C2.00001 6.09036 2.37119 6.89772 3.05819 7.52699L4.40909 6.05218C4.11791 5.78546 4.00001 5.50583 4.00001 5.15909H2.00001ZM3.05536 2.78859C2.37083 3.42046 2.00001 4.22813 2.00001 5.15909H4.00001C4.00001 4.81205 4.11826 4.52926 4.41192 4.2582L3.05536 2.78859ZM5.50001 1.84619C4.56966 1.84619 3.73607 2.16025 3.05536 2.78859L4.41192 4.2582C4.7094 3.9836 5.05337 3.84619 5.50001 3.84619V1.84619Z" fill="#262626" mask="url(#path-1-outside-1)" />
          </svg>
          <span>Санкт-Петербург</span>
        </a>

      </div>
      <div class="is-header__right">
        <a href="tel:+78432060286" class="is-header__phone is-link">  
          <svg fill="#fff" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg"><path d="m.226667 2.57333 2.160003-2.159997c.15111-.151111.32889-.213333.53333-.186667.20444.026667.36889.124445.49333.293334l1.85334 2.58667c.12444.17777.17333.37777.14666.6-.02666.21333-.11555.39555-.26666.54666l-1.58667 1.57334c.90667 1.26222 1.92 2.45333 3.04 3.57333s2.30667 2.1289 3.56 3.0267l1.5867-1.5734c.1511-.1511.3377-.2355.56-.2533.2311-.0178.4311.0356.6.16l2.56 1.8133c.1689.1245.2666.2934.2933.5067.0356.2044-.0222.3822-.1733.5333l-2.1734 2.16c-.0266.0089-.0711.0134-.1333.0134-.0533 0-.1822-.0089-.3867-.0267-.2044-.0178-.4177-.0444-.64-.08-.2133-.0356-.4889-.0978-.8266-.1867-.3378-.0977-.6845-.2177-1.04-.36-.3467-.1422-.7467-.3289-1.20003-.56-.44445-.24-.89334-.5066-1.34667-.8-.45333-.3022-.94667-.6711-1.48-1.1066-.53333-.4445-1.06222-.9289-1.58667-1.4534-.65777-.6577-1.25333-1.32441-1.78666-1.99997-.52445-.68444-.94223-1.30222-1.25334-1.85333s-.57777-1.08-.799997-1.58667c-.222222-.51555-.377777-.96-.466666-1.33333-.08-.38222-.146667-.71556-.2-1-.044445-.28444-.062223-.49778-.053334-.64z" fill="#fff"/></svg>
          <span>8 843 206 02 86</span>
        </a>
        <nav class="is-header__nav header-nav">
          <ul class="header-nav__list">
            <li class="header-nav__item"><a href="#" class="header-nav__text is-link">Для дома</a></li>
            <li class="header-nav__item"><a href="#" class="header-nav__text is-link">Для бизнеса</a></li>
            <li class="header-nav__item"><a href="#" class="header-nav__text is-link">Продукция</a></li>
            <li class="header-nav__item"><a href="#" class="header-nav__text is-link">Акции</a></li>
            <li class="header-nav__item"><a href="#" class="header-nav__text is-link">Контакты</a></li>
          </ul>
        </nav>
        <span class="is-header__menu-btn" role="button" rel="nofollow" aria-haspopup="true" aria-expanded="false" data-gclick="toggleMenu">
          <span id="burger-icon" class="burger">
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
        <rect x="2.86829" y="15.9246" width="22" height="1" transform="rotate(-45 2.86829 15.9246)" fill="#797C80"/>
        <rect x="3.57538" y="0.368164" width="22" height="1" transform="rotate(45 3.57538 0.368164)" fill="#797C80"/>
        </svg>
      </button>
      <div class="dd-menu__scrollable-area">
        <nav class="dd-menu__section">
          <ul class="dd-menu__nav">
            <li class="dd-menu__nav-item"><a href="#" class="dd-menu__text is-link">О компании</a></li>
            <li class="dd-menu__nav-item"><a href="#" class="dd-menu__text is-link">Сервис</a></li>
            <li class="dd-menu__nav-item"><a href="#" class="dd-menu__text is-link">Портфолио</a></li>
            <li class="dd-menu__nav-item"><a href="#" class="dd-menu__text is-link">Решения</a></li>
          </ul>
        </nav>
        <nav class="dd-menu__section">
          <ul class="dd-menu__nav">
            <li class="dd-menu__nav-item"><a href="#" class="dd-menu__text is-link">Архитекторам</a></li>
            <li class="dd-menu__nav-item"><a href="#" class="dd-menu__text is-link">Дилерам</a></li>
            <li class="dd-menu__nav-item"><a href="#" class="dd-menu__text is-link">Прессе</a></li>
          </ul>
        </nav>
        <nav class="dd-menu__section">
          <ul class="dd-menu__nav">
            <li class="dd-menu__nav-item"><a href="#" class="dd-menu__text is-link">Медиа</a></li>
            <li class="dd-menu__nav-item"><a href="#" class="dd-menu__text is-link">Новости</a></li>
            <li class="dd-menu__nav-item"><a href="#" class="dd-menu__text is-link">Советы</a></li>
          </ul>
        </nav>
        <div class="dd-menu__search">
          <form action="q">
            <input type="text" class="is-input" placeholder="Поиск по сайту">
            <button class="button dd-menu__search-submit" type="submit" title="Отправить">
              <svg fill="none" height="18" viewBox="0 0 18 18" width="18" xmlns="http://www.w3.org/2000/svg"><g stroke="#616366" stroke-linecap="round" stroke-linejoin="round" stroke-width=".888889"><path clip-rule="evenodd" d="m7.66667 14.3333c3.68193 0 6.66663-2.9847 6.66663-6.66663 0-3.6819-2.9847-6.66667-6.66663-6.66667-3.6819 0-6.66667 2.98477-6.66667 6.66667 0 3.68193 2.98477 6.66663 6.66667 6.66663z" fill-rule="evenodd"/><path d="m17 16.9999-4.6222-4.6222"/></g></svg>
            </button>
          </form>
        </div>
      </div>
  </div>




    

