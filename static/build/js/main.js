/******/ (function(modules) { // webpackBootstrap
/******/ 	// install a JSONP callback for chunk loading
/******/ 	function webpackJsonpCallback(data) {
/******/ 		var chunkIds = data[0];
/******/ 		var moreModules = data[1];
/******/ 		var executeModules = data[2];
/******/
/******/ 		// add "moreModules" to the modules object,
/******/ 		// then flag all "chunkIds" as loaded and fire callback
/******/ 		var moduleId, chunkId, i = 0, resolves = [];
/******/ 		for(;i < chunkIds.length; i++) {
/******/ 			chunkId = chunkIds[i];
/******/ 			if(Object.prototype.hasOwnProperty.call(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 				resolves.push(installedChunks[chunkId][0]);
/******/ 			}
/******/ 			installedChunks[chunkId] = 0;
/******/ 		}
/******/ 		for(moduleId in moreModules) {
/******/ 			if(Object.prototype.hasOwnProperty.call(moreModules, moduleId)) {
/******/ 				modules[moduleId] = moreModules[moduleId];
/******/ 			}
/******/ 		}
/******/ 		if(parentJsonpFunction) parentJsonpFunction(data);
/******/
/******/ 		while(resolves.length) {
/******/ 			resolves.shift()();
/******/ 		}
/******/
/******/ 		// add entry modules from loaded chunk to deferred list
/******/ 		deferredModules.push.apply(deferredModules, executeModules || []);
/******/
/******/ 		// run deferred modules when all chunks ready
/******/ 		return checkDeferredModules();
/******/ 	};
/******/ 	function checkDeferredModules() {
/******/ 		var result;
/******/ 		for(var i = 0; i < deferredModules.length; i++) {
/******/ 			var deferredModule = deferredModules[i];
/******/ 			var fulfilled = true;
/******/ 			for(var j = 1; j < deferredModule.length; j++) {
/******/ 				var depId = deferredModule[j];
/******/ 				if(installedChunks[depId] !== 0) fulfilled = false;
/******/ 			}
/******/ 			if(fulfilled) {
/******/ 				deferredModules.splice(i--, 1);
/******/ 				result = __webpack_require__(__webpack_require__.s = deferredModule[0]);
/******/ 			}
/******/ 		}
/******/
/******/ 		return result;
/******/ 	}
/******/
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// object to store loaded and loading chunks
/******/ 	// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 	// Promise = chunk loading, 0 = chunk loaded
/******/ 	var installedChunks = {
/******/ 		"main": 0
/******/ 	};
/******/
/******/ 	var deferredModules = [];
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	var jsonpArray = window["webpackJsonp"] = window["webpackJsonp"] || [];
/******/ 	var oldJsonpFunction = jsonpArray.push.bind(jsonpArray);
/******/ 	jsonpArray.push = webpackJsonpCallback;
/******/ 	jsonpArray = jsonpArray.slice();
/******/ 	for(var i = 0; i < jsonpArray.length; i++) webpackJsonpCallback(jsonpArray[i]);
/******/ 	var parentJsonpFunction = oldJsonpFunction;
/******/
/******/
/******/ 	// add entry module to deferred list
/******/ 	deferredModules.push(["./src/js/main.js","vendor"]);
/******/ 	// run deferred modules when ready
/******/ 	return checkDeferredModules();
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/helpers.js":
/*!***************************!*\
  !*** ./src/js/helpers.js ***!
  \***************************/
/*! exports provided: lastPageYOffset, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "lastPageYOffset", function() { return lastPageYOffset; });
var vars = {};
var lastPageYOffset = null;
vars.$document = $(document);
vars.$window = $(window);
vars.$body = $(document.body);
vars.$html = $(document.documentElement);
vars.$siteContainer = $('.site-container');
vars.$preloader = $('.preloader');
vars.$header = $('.header');

vars.isMobile = function () {
  return innerWidth <= 1024;
};

vars.isIE = function () {
  return vars.$html.hasClass('is-browser-ie');
};

vars.winWidth = window.innerWidth;
var debounced = [];

var cancelFunc = function cancelFunc(timeout) {
  return function () {
    clearTimeout(timeout);
  };
};

vars.debounce = function (fn, wait) {
  var d = debounced.find(function (_ref) {
    var funcString = _ref.funcString;
    return funcString === fn.toString();
  });

  if (d) {
    d.cancel();
  } else {
    d = {};
    debounced.push(d);
  }

  d.func = fn;
  d.funcString = fn.toString();

  for (var _len = arguments.length, args = new Array(_len > 2 ? _len - 2 : 0), _key = 2; _key < _len; _key++) {
    args[_key - 2] = arguments[_key];
  }

  d.timeout = setTimeout.apply(void 0, [fn, wait].concat(args));
  d.cancel = cancelFunc(d.timeout);
};

vars.saveScrollPosition = function () {
  vars.$html.css('scroll-behavior', 'initial');
  lastPageYOffset = window.pageYOffset || document.documentElement.scrollTop;
};

vars.restoreScrollPosition = function () {
  if (lastPageYOffset !== null) {
    window.scrollTo(window.pageXOffset, lastPageYOffset);
    lastPageYOffset = null;
    vars.$html.css('scroll-behavior', '');
  }
}; // smooth scrolling


vars.scrollTo = function ($container) {
  var time = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 500;
  var offset = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
  vars.$html.css('scroll-behavior', 'initial');
  $('html, body').animate({
    scrollTop: "".concat($container.offset().top + offset)
  }, time);
  setTimeout(function () {
    vars.$html.css('scroll-behavior', '');
  }, time + 100);
};

var scrollDiv;

vars.getScrollbarWidth = function () {
  var width = window.innerWidth - vars.$html.clientWidth;

  if (width) {
    return width;
  } // Document doesn't have a scrollbar, possibly because there is not enough content so browser doesn't show it


  if (!scrollDiv) {
    scrollDiv = document.createElement('div');
    scrollDiv.style.cssText = 'width:100px;height:100px;overflow:scroll !important;position:absolute;top:-9999px';
    document.body.appendChild(scrollDiv);
  }

  return scrollDiv.offsetWidth - scrollDiv.clientWidth;
};

function hasHoverSupport() {
  var hoverSupport;

  if (vars.isIE && vars.getScrollbarWidth()) {
    // On touch devices scrollbar width is usually 0
    hoverSupport = true;
  } else if (vars.isMobile()) {
    hoverSupport = false;
  } else if (window.matchMedia('(any-hover: hover)').matches || window.matchMedia('(hover: hover)').matches) {
    hoverSupport = true;
  } else if (window.matchMedia('(hover: none)').matches) {
    hoverSupport = false;
  } else {
    hoverSupport = typeof vars.$html.ontouchstart === 'undefined';
  }

  return hoverSupport;
}

if (!hasHoverSupport()) {
  vars.$html.removeClass('has-hover').addClass('no-hover');
} else {
  vars.$html.removeClass('no-hover').addClass('has-hover');
}

function resize() {
  vars.debounce(function () {
    if (vars.winWidth !== window.innerWidth) {
      if (!hasHoverSupport()) {
        vars.$html.removeClass('has-hover').addClass('no-hover');
      } else {
        vars.$html.removeClass('no-hover').addClass('has-hover');
      }

      vars.winWidth = window.innerWidth;
    }
  }, 300);
}

vars.$window.on('resize', resize);
/* harmony default export */ __webpack_exports__["default"] = (vars);

/***/ }),

/***/ "./src/js/main.js":
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _vendor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./vendor */ "./src/js/vendor.js");
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./helpers */ "./src/js/helpers.js");
/* harmony import */ var swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! swiper/dist/js/swiper.js */ "./node_modules/swiper/dist/js/swiper.js");
/* harmony import */ var swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var wow_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! wow.js */ "./node_modules/wow.js/dist/wow.js");
/* harmony import */ var wow_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(wow_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var select2__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! select2 */ "./node_modules/select2/dist/js/select2.js");
/* harmony import */ var select2__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(select2__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _fancyapps_fancybox__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @fancyapps/fancybox */ "./node_modules/@fancyapps/fancybox/dist/jquery.fancybox.js");
/* harmony import */ var _fancyapps_fancybox__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_fancyapps_fancybox__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var inputmask_dist_jquery_inputmask__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! inputmask/dist/jquery.inputmask */ "./node_modules/inputmask/dist/jquery.inputmask.js");
/* harmony import */ var inputmask_dist_jquery_inputmask__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(inputmask_dist_jquery_inputmask__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var jquery_validation__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! jquery-validation */ "./node_modules/jquery-validation/dist/jquery.validate.js");
/* harmony import */ var jquery_validation__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(jquery_validation__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _node_modules_jquery_validation_dist_localization_messages_ru_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../../node_modules/jquery-validation/dist/localization/messages_ru.js */ "./node_modules/jquery-validation/dist/localization/messages_ru.js");
/* harmony import */ var _node_modules_jquery_validation_dist_localization_messages_ru_js__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_node_modules_jquery_validation_dist_localization_messages_ru_js__WEBPACK_IMPORTED_MODULE_8__);









jQuery.extend(jQuery.validator.messages, {
  required: 'Поле обязательно для заполнения',
  email: 'Неверный или некорректный e-mail адрес'
});
$.validator.addMethod("regex", function (value, element, regexp) {
  if (regexp && regexp.constructor != RegExp) {
    regexp = new RegExp(regexp[0], regexp[1]);
  } else if (regexp.global) regexp.lastIndex = 0;

  return this.optional(element) || regexp.test(value);
}, 'Поле может содержать только буквы');
var $window, $document, $body, globalXHRStatus, yModalConfig;
var conf = {
  'fancyStatus': false,
  'nodeBody': $('#body'),
  'fancyDefault': {
    wrapCSS: 'fb-fancy-default',
    padding: 0,
    margin: 0,
    autoScale: false,
    fitToView: false,
    openSpeed: 300,
    closeSpeed: 300,
    nextSpeed: 300,
    prevSpeed: 300,
    closeBtn: false,
    toolbar: false,
    afterShow: function afterShow() {
      conf.nodeBody.addClass('body-state-fancy'); // this modal parent

      var $thisFancy = $('.fancybox-inner');
      moduleApp.executeModules($thisFancy);
    },
    beforeClose: function beforeClose() {
      conf.nodeBody.removeClass('body-state-fancy');
    },
    afterClose: function afterClose() {
      conf.fancyStatus = false;
    }
  }
};
var moduleApp = {
  'init': function init() {
    this.initGlobals();
    this.initGlobalsEvents(); //this.startupMessage();

    this.executeModules();
    this.loaderImages();
    this.pageLoader();
    this.pagePreLoader();
  },
  'getRandom': function getRandom(min, max) {
    return Math.round(min - 0.5 + Math.random() * (max - min + 1));
  },
  'initGlobals': function initGlobals() {
    $window = $(window);
    $document = $(document);
    $body = $('#body');
    globalXHRStatus = false;
    $window.on('load', function () {
      $window.trigger('resize');
    });
    new wow_js__WEBPACK_IMPORTED_MODULE_3___default.a().init();
  },
  'initGlobalsEvents': function initGlobalsEvents() {
    var methods = {
      'init': function init() {
        methods.getInitialEvents('click');
        methods.getInitialEvents('change');
      },
      'getInitialEvents': function getInitialEvents(thisEvent) {
        $document.on(thisEvent, '[data-g' + thisEvent + ']', function (e) {
          e.preventDefault();
          var $this = $(this);
          var thisAction = $this.attr('data-g' + thisEvent);
          var thisValue = $this.val() || $this.data().value;

          if (actions[thisAction]) {
            actions[thisAction]($this, thisValue);
          } else {
            console.log('Event: ' + thisEvent + ', Action:"' + thisAction + '" - not defined');
          }
        });
      },
      'getTarget': function getTarget(thisTarget) {
        return $('[data-target="' + thisTarget + '"]');
      }
    };
    var actions = {
      'toggleMenu': function toggleMenu($this) {
        $('#ddMenu').toggleClass('is-active');
        $('html').toggleClass('is-show-menu');
      },
      'closeFancy': function closeFancy() {
        $.fancybox.close();
      },
      'share-page': function sharePage($this, thisValue) {
        var shareService = thisValue;
        var shareData = {
          'link': $('[property="og:url"]').attr('content'),
          'title': encodeURI($('[property="og:title"]').attr('content')),
          'description': encodeURI($('[property="og:description"]').attr('content')),
          'image': $('[property="og:image"]').attr('content')
        };
        var windowLink = 'http://share.yandex.ru/go.xml?service=' + shareService;
        var fbWindowLink = 'http://www.facebook.com/sharer/sharer.php?';
        windowLink += '&title=' + shareData.title;

        if (shareService == 'twitter') {
          windowLink += ' ' + shareData.description;
          windowLink += '&url=' + shareData.link;
          windowLink += '&link=' + shareData.link;
        } else if (shareService == 'facebook') {
          fbWindowLink += 'u=' + shareData.link;
        } else {
          windowLink += '&url=' + shareData.link;
          windowLink += '&link=' + shareData.link;
          windowLink += '&description=' + shareData.description;
          windowLink += '&image=' + shareData.image;
        }

        if (shareService == 'facebook') {
          window.open(fbWindowLink, '', 'toolbar=0,status=0,width=625,height=435');
        } else {
          window.open(windowLink, '', 'toolbar=0,status=0,width=625,height=435');
        }
      },
      'scroll-to-anchor': function scrollToAnchor($this) {
        var target = $this.attr('href');

        if (target.length) {
          $('html, body').stop().animate({
            scrollTop: $(target).offset().top - 70
          }, 700);
        }
      },
      'scroll-top': function scrollTop() {
        $('html,body').animate({
          scrollTop: 0
        }, 700);
      }
    };
    methods.init();
  },
  'executeModules': function executeModules() {
    $('[data-is]').each(function (i, thisModule) {
      var $thisModule = $(thisModule);
      var thisModuleName = $thisModule.attr('data-is');

      if (moduleApp[thisModuleName]) {
        console.log('Auto start: `' + thisModuleName + '`.');
        moduleApp[thisModuleName]($thisModule);
      } else {
        console.log('Module: `' + thisModuleName + '` is not defined.');
      }
    });
  },
  'pageLoader': function pageLoader() {
    $body.addClass('jsfx-loaded');
    setTimeout(function () {
      moduleApp.inViewLoader();
    }, 300);
  },
  'pagePreLoader': function pagePreLoader() {
    $(".loader_inner").fadeOut();
    $(".loader").delay(100).fadeOut("slow");
  },
  'inViewLoader': function inViewLoader() {
    var hiddenClass = 'view-hidden';
    var $inView = $('.' + hiddenClass);
    $inView.each(function (i, e) {
      var $e = $(e);
      var r1 = parseInt(Math.random() * 1000) + 500;
      var r2 = parseInt(Math.random() * 200);
      var string = 'transition-duration:' + r1 + 'ms;transition-delay:' + r2 + 'ms;transition-property:opacity;';
      var style = $e.attr('style');

      if (style) {
        string = string + style;
      }

      $e.attr('style', string);
    });
    $inView.on('inview', function (event, isInView) {
      if (isInView) {
        $(this).removeClass(hiddenClass);
      }
    });
  },
  'startupMessage': function startupMessage() {
    if (appConfig.startupMessage.title && appConfig.startupMessage.message) {
      var t = '<div class="fb-modal-default">';
      t += '<a class="is-cross-link" data-gclick="closeFancy" href="#"><img src="/assets/img/icon-cross.svg" alt=""></a>';
      t += '<div class="md-body">' + appConfig.startupMessage.message + '</div>';
      t += '</div>';
      var thisFancyConfig = $.extend({}, conf.fancyDefault, {
        content: t
      });
      $.fancybox.open(t, thisFancyConfig);
    }
  },
  'loaderImages': function loaderImages($img) {
    var inviewFlag = true;

    if (!$img) {
      $img = $('[data-img]');
    }

    $img.each(function (i, thisImg) {
      var $thisImage = $(thisImg);
      var $parentNode = $thisImage.parent();
      var imgUrl = $thisImage.data().img || '';
      var imgMiddle = $thisImage.data().middle || false;
      var imgVisible = $thisImage.data().visible || false;
      var nativeStyle = $thisImage.attr('style') || '';

      if (!imgVisible) {
        $thisImage.addClass('sfx-hidden');
      }

      $thisImage.removeAttr('data-img');
      var tempImage = new Image();
      tempImage.src = imgUrl;

      tempImage.onload = function () {
        var r1 = moduleApp.getRandom(500, 1200);
        var r2 = moduleApp.getRandom(0, 300);

        if ($thisImage.data('img-fast')) {
          var r1 = 0;
          var r2 = 0;
        }

        if ($thisImage.is('img')) {
          $thisImage.attr('src', imgUrl);

          if (imgMiddle) {
            var middleArray = {};
            middleArray.width = parseInt($thisImage.width());
            middleArray.height = parseInt($thisImage.height());
            middleArray.halfTop = parseInt(middleArray.height / 2);
            middleArray.halfLeft = parseInt(middleArray.width / 2);
            nativeStyle += 'position:absolute;display:block;top:50%;left:50%;width:' + middleArray.width + 'px;height:' + middleArray.height + 'px;margin:-' + middleArray.halfTop + 'px 0 0 -' + middleArray.halfLeft + 'px;';
          }

          $thisImage.attr('style', nativeStyle + 'transition-property:opacity;transition-duration:' + r1 + 'ms;transition-delay:' + r2 + 'ms;');
        } else {
          $thisImage.attr('style', nativeStyle + 'background-image:url(' + imgUrl + ');transition-property:opacity;transition-duration:' + r1 + 'ms;transition-delay:' + r2 + 'ms;');
        }

        if ($parentNode.hasClass('js-zoom-image')) $parentNode.zoom();
      };
    });

    if (inviewFlag) {
      $img.on('inview', function (event, isInView, howView) {
        if (isInView) {
          var $this = $(this);
          $(this).removeClass('sfx-hidden');
        }
      });
    } else {
      $img.removeClass('sfx-hidden');
    }
  },
  'index-slider': function indexSlider($thisModule) {
    var swiper,
        $parent = $thisModule.find('.swiper-container'),
        $btnPrev = $thisModule.find('.js_btn-prev'),
        $btnNext = $thisModule.find('.js_btn-next'),
        $pager = $thisModule.find('.swiper-pagination');
    swiper = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($parent, {
      slidesPerView: 1,
      spaceBetween: 10,
      preloadImages: false,
      speed: 0,
      autoplay: {
        delay: 6000,
        disableOnInteraction: false
      },
      loop: true,
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
      navigation: {
        nextEl: $btnNext,
        prevEl: $btnPrev
      },
      lazy: {
        loadPrevNext: true
      },
      pagination: {
        el: $pager,
        clickable: true
      }
    });
  },
  'page-slider': function pageSlider($thisModule) {
    var swiper,
        $parent = $thisModule.find('.swiper-container'),
        $pager = $thisModule.find('.js-pager');
    swiper = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($parent, {
      slidesPerView: 'auto',
      spaceBetween: 32,
      breakpoints: {
        1023: {
          spaceBetween: 24
        }
      },
      pagination: {
        el: $pager,
        clickable: true
      }
    });
    $window.resize(function () {
      swiper.update();

      if ($pager.find('.swiper-pagination-bullet').length < 2) {
        $pager.hide();
      } else {
        $pager.show();
      }
    });
  },
  'advantages-slider': function advantagesSlider($thisModule) {
    var swiper,
        $parent = $thisModule.find('.swiper-container'),
        $pager = $thisModule.find('.js-pager');
    swiper = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($parent, {
      slidesPerView: 1,
      spaceBetween: 24,
      touchRatio: 0,
      shortSwipes: false,
      longSwipes: false,
      speed: 800,
      autoplay: {
        delay: 4000
      },
      loop: true,
      pagination: {
        el: $pager[0],
        clickable: true,
        renderBullet: function renderBullet(index, className) {
          var number;

          if (index + 1 < 10) {
            number = '0' + (index + 1);
          } else {
            number = index + 1;
          }

          return '<span class="' + className + '">' + number + '</span>';
        }
      },
      on: {
        slideChange: function slideChange() {
          $('.page-index__about-sect__image').removeClass('is-shown');
          $('.page-index__about-sect__image').eq(this.realIndex).addClass('is-shown');
        }
      }
    });
  },
  'tabs-nav': function tabsNav($thisModule, inputConfig) {
    var defaultConfig = {
      'speed': '300',
      'initAttr': 'data-tab-body',
      'initAttrType': '.',
      'onBeforeChange': false,
      'onAfterChange': false,
      // private config
      'opacityDuration': '150',
      'opacityDelay': '150',
      'wrapperClass': '.is-tabs__wrapper',
      'contentClass': '.is-tabs__tab',
      'navLinkClass': '> a, > .is-tabs__link'
    };
    var tabsConfig = $.extend({}, defaultConfig, inputConfig);
    var debouncer = false;
    var playStringRaw = 'transition:height ' + tabsConfig.speed + 'ms 0s, opacity ' + (parseInt(tabsConfig.speed) + parseInt(tabsConfig.opacityDuration)) + 'ms ' + tabsConfig.opacityDuration + 'ms;';
    var playStringCSS = '-webkit-' + playStringRaw + '-moz-' + playStringRaw + '-ms-' + playStringRaw + '-o-' + playStringRaw + playStringRaw;
    var containerBox = $thisModule.attr(tabsConfig.initAttr) || false;
    var $navLinks = $thisModule.find(tabsConfig.navLinkClass);
    var $containerBox = $(tabsConfig.initAttrType + containerBox);
    var $wrapperBox = $containerBox.find(tabsConfig.wrapperClass);
    var $contentBox = $containerBox.find(tabsConfig.contentClass);
    var cH = $wrapperBox.outerHeight();
    var lastIndex = -1;
    var tabsCore = {
      'addEvent': function addEvent() {
        $navLinks.on('click focus', function (e) {
          e.preventDefault();
          var $this = $(this);

          if (debouncer || $this.hasClass('active')) {
            return false;
          }

          debouncer = true;
          var thisIndex = $this.index();
          $navLinks.removeClass('active');
          $this.addClass('active');

          if (tabsConfig.onBeforeChange) {
            var cbReturn = tabsConfig.onBeforeChange({
              'oldIndex': lastIndex,
              'newIndex': thisIndex,
              'thisLink': $this,
              'thisContent': $contentBox.eq(thisIndex)
            });

            if (cbReturn === false) {
              debouncer = false;
              return false;
            }
          }

          $containerBox.attr('style', 'opacity:0;height:' + cH + 'px;');
          tabsCore.changeTab(thisIndex);
        });
      },
      'changeTab': function changeTab(thisIndex) {
        $contentBox.hide().eq(thisIndex).show();
        cH = $wrapperBox.outerHeight();
        $containerBox.attr('style', 'opacity:1;height:' + cH + 'px;' + playStringCSS);
        setTimeout(function () {
          $containerBox.attr('style', 'height:auto;');

          if (tabsConfig.onAfterChange) {
            var cbReturn = tabsConfig.onAfterChange({
              'oldIndex': lastIndex,
              'newIndex': thisIndex,
              'thisLink': $navLinks.eq(thisIndex),
              'thisContent': $contentBox.eq(thisIndex)
            });

            if (cbReturn === false) {
              debouncer = false;
              return false;
            }
          }

          lastIndex = thisIndex;
          debouncer = false;
          $containerBox.find('.swiper-container').each(function (index, item) {
            var $item = $(item);
            $item[0].swiper.update();
          });
          $window.trigger('resize');
        }, parseInt(tabsConfig.speed) + 25);
      }
    }; // init

    tabsCore.addEvent();
    $navLinks.eq(0).addClass('active');
  }
};
var pageApp = {
  'init': function init() {
    var curApp = $('#app').attr('data-app');

    if (pageApp[curApp]) {
      pageApp[curApp]();
    }
  },
  'page-index': function pageIndex() {
    console.log('index-here');
  }
};
$(document).ready(function () {
  moduleApp.init(); // pageApp.init();
});
var $document2 = $(document);
var $window2 = $(window);
var $html = $('html');
var app = {
  'global': {
    init: function init() {
      $('.js-goto').on('click', function (e) {
        var $target = $($(e.currentTarget).data('target') || $(e.currentTarget).attr('href'));

        if ($target.length) {
          e.preventDefault();
          window.scrollTo(0, $target.offset().top - 140);
        }
      });
      $('[data-fancybox]').fancybox({
        backFocus: false,
        touch: false,
        afterShow: function afterShow() {
          $('.fancybox-container:visible .swiper-container').each(function (index, item) {
            var $item = $(item);

            if ($item.data('slider')) {
              $item.data('slider').update();
            }
          });
        }
      });
      $('.modal__gif img').hover(function () {
        $(this).attr('src', './images/lift-and-turn.gif');
      }, function () {
        $(this).attr('src', './images/lift-and-turn-static.gif');
      });
      app.sked.init();
    }
  },
  'header': {
    init: function init($header) {
      $header.find('.is-header__location').on('click', function (e) {
        var $this = $(e.currentTarget);
        var $parent = $this.closest('.is-header__left');
        var $drop = $parent.find('.is-header__location__drop');
        e.preventDefault();
        $parent.toggleClass('is-show-geo');

        if ($parent.hasClass('is-show-geo')) {
          $drop.stop().slideDown(250);
        } else {
          $drop.stop().slideUp(250);
        }
      });
      $header.find('.is-header__location__drop__btns__yes').on('click', function (e) {
        e.preventDefault();
        localStorage.confirmLocation = 'yes';
        $header.find('.is-header__left').removeClass('is-show-geo');
        $header.find('.is-header__location__drop').stop().slideUp(250);
      });
      $document2.on('click', function (e) {
        var $target = $(e.target);

        if (!$target.closest('.is-header__left.is-show-geo').length) {
          $header.find('.is-header__left.is-show-geo .is-header__location__drop').stop().slideUp(250);
          $header.find('.is-header__left.is-show-geo').removeClass('is-show-geo');
        }
      });
      $header.addClass('animated');
      $window2.on('scroll', function () {
        if ($window2.scrollTop() > 0) {
          $header.addClass('is-fixed');
        } else {
          $header.removeClass('is-fixed');
        }
      });
    }
  },
  'dd-menu': {
    init: function init($menu) {
      if (device.mobile()) {
        $menu.find('.dd-menu__nav-item__arrow').on('click', function (e) {
          var $this = $(e.currentTarget);
          var $item = $this.closest('.dd-menu__nav li');
          var $drop = $item.find('.header-nav__item__drop');
          e.preventDefault();
          $item.toggleClass('is-active');

          if ($item.hasClass('is-active')) {
            $drop.stop().slideDown(250);
          } else {
            $drop.stop().slideUp(250);
          }
        });
      }
    }
  },
  'geo': {
    init: function init($geo) {
      var checkFill = function checkFill() {
        if ($geo.find('.modal__select select').val()) {
          $geo.addClass('is-filled');
        } else {
          $geo.removeClass('is-filled');
        }
      };

      document.querySelectorAll('.modal-geo a').forEach(function (link, index) {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          var city = link.getAttribute('href').replace('?set-city=', '');
          $.ajax({
            type: 'post',
            url: '/ajax/set_city.php',
            data: {
              city: city
            },
            success: function success(result) {
              console.log(result);
              document.querySelector('.is-header__location-div span').textContent = city;
              $.fancybox.close();
            }
          });
        });
      });
      $geo.find('.modal__select select').on('change', function () {
        localStorage.confirmLocation = 'yes';
      });
      $geo.find('.modal__city a').on('click', function (e) {
        e.preventDefault();
        localStorage.confirmLocation = 'yes';
      });
      $geo.find('.modal__select select').select2({
        dropdownParent: $geo.find('.modal__select'),
        ajax: {
          url: $geo.find('.modal__select').data('geo'),
          dataType: 'json'
        }
      });
      checkFill();
      $geo.on('change', function () {
        checkFill();
      });
    }
  },
  'edge': {
    init: function init($slider) {
      var numbers = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.edge__number .swiper-container'), {
        slidesPerView: 'auto',
        spaceBetween: 8,
        allowTouchMove: false
      });
      var inner = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.edge__inner .swiper-container'), {
        slidesPerView: 1,
        spaceBetween: 16,
        loop: true,
        speed: 800,
        autoplay: {
          delay: 4000,
          disableOnInteraction: false
        },
        on: {
          slideChange: function slideChange() {
            $slider.find('.edge__image img').removeClass('is-shown');
            $slider.find('.edge__image img').eq(this.realIndex).addClass('is-shown');
          }
        },
        thumbs: {
          swiper: numbers
        }
      });
      $window2.on('load', function () {
        numbers.update();
        inner.update();
      });
    }
  },
  'slider-item': {
    init: function init($slider) {
      if ($slider.find('.swiper-slide').length < 2) {
        $slider.find('.slider__pager').hide();
      }

      new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 32,
        slidesPerView: 'auto',
        allowTouchMove: $slider.find('.swiper-slide').length < 2 ? false : true,
        breakpoints: {
          1023: {
            spaceBetween: 25
          }
        },
        pagination: {
          el: $slider.find('.slider__pager')[0],
          clickable: true
        }
      });
    }
  },
  'slider-list': {
    init: function init($slider) {
      var slider = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 32,
        slidesPerView: 1,
        breakpoints: {
          1023: {
            spaceBetween: 25,
            slidesPerView: 'auto'
          }
        },
        pagination: {
          el: $slider.find('.slider__pager')[0],
          clickable: true
        }
      });
    }
  },
  'slider-videos': {
    init: function init($slider) {
      new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 32,
        slidesPerView: 2,
        breakpoints: {
          1023: {
            spaceBetween: 25,
            slidesPerView: 'auto'
          }
        },
        pagination: {
          el: $slider.find('.slider__pager')[0],
          clickable: true
        }
      });
    }
  },
  'slider-goods': {
    init: function init($slider) {
      new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 32,
        slidesPerView: 3,
        breakpoints: {
          1023: {
            spaceBetween: 25,
            slidesPerView: 'auto'
          }
        },
        pagination: {
          el: $slider.find('.slider__pager')[0],
          clickable: true
        }
      });
    }
  },
  'slider-educ': {
    init: function init($slider) {
      new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 32,
        slidesPerView: 2,
        breakpoints: {
          1023: {
            spaceBetween: 25,
            slidesPerView: 'auto'
          }
        }
      });
    }
  },
  'slider-create': {
    init: function init($slider) {
      new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 16,
        slidesPerView: 1,
        navigation: {
          prevEl: $slider.find('.create__slider__arrow_prev')[0],
          nextEl: $slider.find('.create__slider__arrow_next')[0]
        },
        pagination: {
          el: $slider.find('.create__slider__pager')[0],
          type: 'fraction',
          formatFractionCurrent: function formatFractionCurrent(number) {
            return number < 10 ? "".concat(number) : number;
          },
          formatFractionTotal: function formatFractionTotal(number) {
            return number < 10 ? "".concat(number) : number;
          }
        }
      });
    }
  },
  'slider-sked': {
    init: function init($slider) {
      var slider = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 16,
        slidesPerView: 1,
        navigation: {
          prevEl: $slider.find('.modal__slider__arrow_prev')[0],
          nextEl: $slider.find('.modal__slider__arrow_next')[0]
        },
        pagination: {
          el: $slider.find('.modal__slider__pager')[0],
          type: 'fraction',
          formatFractionCurrent: function formatFractionCurrent(number) {
            return number < 10 ? "".concat(number) : number;
          },
          formatFractionTotal: function formatFractionTotal(number) {
            return number < 10 ? "".concat(number) : number;
          }
        }
      });
      $slider.find('.swiper-container').data('slider', slider);
    }
  },
  'slider-images': {
    init: function init($slider) {
      new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 32,
        slidesPerView: 3,
        breakpoints: {
          1023: {
            spaceBetween: 25,
            slidesPerView: 'auto'
          }
        },
        pagination: {
          el: $slider.find('.slider__pager')[0],
          clickable: true
        }
      });
    }
  },
  'slider-advice': {
    init: function init($slider) {
      var slider = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 32,
        slidesPerView: 3,
        breakpoints: {
          1023: {
            spaceBetween: 25,
            slidesPerView: 'auto'
          }
        },
        pagination: {
          el: $slider.find('.slider__pager')[0],
          clickable: true
        }
      });
    }
  },
  'slider-leveler-platforms': {
    init: function init($slider) {
      var slider = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 32,
        slidesPerView: 2,
        breakpoints: {
          1023: {
            spaceBetween: 25,
            slidesPerView: 'auto'
          }
        },
        pagination: {
          el: $slider.find('.slider__pager')[0],
          clickable: true
        }
      });
    }
  },
  'story': {
    init: function init($story) {
      var $slider = $story.find('.slider');
      var $list = $story.find('.story__tabs__list ul li a');
      var $items = $story.find('.story__tabs__item');
      new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 32,
        slidesPerView: 3,
        breakpoints: {
          1023: {
            spaceBetween: 25,
            slidesPerView: 'auto'
          }
        }
      });
      $list.on('click', function (e) {
        var $this = $(e.currentTarget);
        var $item = $(".story__tabs__item[data-item=\"".concat($this.data('target'), "\"]"));
        e.preventDefault();

        if (!$this.hasClass('is-active')) {
          $items.removeClass('is-active');
          $list.removeClass('is-active');
          $item.addClass('is-active');
          $this.addClass('is-active');
        }
      });
    }
  },
  'make': {
    init: function init($make) {
      var $list = $make.find('.make__list ul li a');
      var $items = $make.find('.make__item');
      $list.on('click', function (e) {
        var $this = $(e.currentTarget);
        var $item = $(".make__item[data-item=\"".concat($this.data('target'), "\"]"));
        e.preventDefault();

        if (!$this.hasClass('is-active')) {
          $items.removeClass('is-active');
          $list.removeClass('is-active');
          $item.addClass('is-active');
          $this.addClass('is-active');

          if ($item.find('.swiper-container').length) {
            $item.find('.swiper-container').data('slider').update();
          }
        }
      });
      $make.find('.make__item').each(function (index, item) {
        var $item = $(item);
        var slider = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($item.find('.swiper-container'), {
          spaceBetween: 16,
          slidesPerView: 1,
          navigation: {
            prevEl: $item.find('.make__slider__arrow_prev')[0],
            nextEl: $item.find('.make__slider__arrow_next')[0]
          },
          pagination: {
            el: $item.find('.make__slider__pager')[0],
            type: 'fraction',
            formatFractionCurrent: function formatFractionCurrent(number) {
              return number < 10 ? "".concat(number) : number;
            },
            formatFractionTotal: function formatFractionTotal(number) {
              return number < 10 ? "".concat(number) : number;
            }
          }
        });
        $item.find('.swiper-container').data('slider', slider);
      });
    }
  },
  'catalog-filter': {
    init: function init($filter) {
      var $list = $filter.find('.catalog__filter__option button');
      var $items = $filter.find('.catalog__filter__opt');
      $filter.find('.btn-parameters').on('click', function (e) {
        var $drop = $filter.find('.catalog__filter__drop');
        e.preventDefault();
        $drop.toggleClass('is-show');

        if ($drop.hasClass('is-show')) {
          $drop.stop().slideDown(250);
        } else {
          $drop.stop().slideUp(250);
        }
      });
      $list.on('click', function (e) {
        var $this = $(e.currentTarget);
        var $item = $(".catalog__filter__opt[data-item=\"".concat($this.data('target'), "\"]"));
        e.preventDefault();

        if (!$this.hasClass('is-active')) {
          $items.removeClass('is-active');
          $list.removeClass('is-active');
          $item.addClass('is-active');
          $this.addClass('is-active');
        }
      });
    }
  },
  'select': {
    init: function init($select) {
      var checkFill = function checkFill() {
        if ($select.find('select').val()) {
          $select.addClass('is-filled');
        } else {
          $select.removeClass('is-filled');
        }
      };

      $select.find('select').select2({
        minimumResultsForSearch: Infinity,
        dropdownParent: $select
      });
      checkFill();
      $select.on('change', function () {
        checkFill();
      });
    }
  },
  'catalogue-more': {
    init: function init($catalogue) {
      $catalogue.find('.catalogue__option__more button').on('click', function (e) {
        var $this = $(e.currentTarget);
        var $drop = $catalogue.find('.checkbox-drop');
        e.preventDefault();
        $this.addClass('is-hidden');
        $drop.addClass('is-active');
      });
    }
  },
  'accordion': {
    init: function init($accordion) {
      $accordion.find('.title-text').on('click', function (e) {
        var $this = $(e.currentTarget);
        var $item = $this.closest('.accordion__item');
        var $drop = $item.find('.accordion__drop');
        e.preventDefault();

        if ($this.hasClass('is-active')) {
          $this.removeClass('is-active');
          $drop.stop().slideUp(250);
        } else {
          $accordion.find('.title-text.is-active').removeClass('is-active');
          $accordion.find('.accordion__drop:visible').slideUp(250);
          $this.addClass('is-active');
          $drop.stop().slideDown(250);
        }
      });
    }
  },
  'form': {
    init: function init($form) {
      var validator = $form.validate({
        lang: 'ru',
        rules: {},
        submitHandler: function submitHandler(form) {
          if ($form.data('type') === 'submit') {
            form.submit();
          } else {
            var preparedData;
            var processData;
            var contentType;
            $form.removeClass('is-sended is-error');

            if ($form.find('input[type="file"]').length > 0) {
              preparedData = new FormData($form.get()[0]);
              processData = false;
              contentType = false;
            }

            $.ajax({
              type: $form.attr('method'),
              url: $form.attr('action'),
              data: preparedData ? preparedData : $form.serialize(),
              dataType: 'json',
              processData: processData,
              contentType: contentType,
              success: function success(result) {
                if (result.result === true) {
                  $form[0].reset();
                  $form.find('.form__file__title').text('Приложите файл');
                  $.fancybox.close();
                }

                $.fancybox.open("<div class=\"modal modal-alert\">\n\t\t\t\t\t\t\t\t\t<div class=\"modal__alert\">".concat(result.message, "</div>\n\t\t\t\t\t\t\t\t</div>"), {
                  touch: false,
                  autoFocus: false
                });
              }
            });
          }
        }
      });
      setTimeout(function () {
        $form.find('[data-validation]').each(function (index, item) {
          $(item).rules('add', $(item).data('validation'));
        });
      }, 1000);
      $form.find('.form__file input').on('change', function (e) {
        var $this = $(e.currentTarget);
        var $file = $this.closest('.form__file');
        var $text = $this.closest('.form__file').find('.form__file__title');

        if (e.target.files.length === 0) {
          $text.text($text.data('text'));
          $file.removeClass('is-file-selected');
        } else if (e.target.files.length === 1) {
          $text.text(e.target.files[0].name);
          $file.addClass('is-file-selected');
        } else {
          $text.text("".concat($text.data('multiple') || 'Files count:', " ").concat(e.target.files.length));
          $file.addClass('is-file-selected');
        }

        $(e.currentTarget).valid();
      });
    }
  },
  'mask': {
    init: function init($mask) {
      $mask.inputmask($mask.data('mask').toString(), {
        showMaskOnHover: false,
        clearIncomplete: true
      });
    }
  },
  'contacts': {
    init: function init($contacts) {
      var $items = $contacts.find('.contacts__item');
      var $map = $contacts.find('.contacts__map');
      var map;
      var $list = $contacts.find('.contacts__list');
      var $listScroll = $contacts.find('.contacts__list__scroll');
      var filter = [];
      var markers = [];

      var collectFilter = function collectFilter() {
        filter = [];
        $contacts.find('.form__radio input:checked').each(function (index, item) {
          filter.push($(item).val());
        });
      };

      var showItems = function showItems() {
        map.geoObjects.removeAll();
        collectFilter();
        $items.each(function (index, item) {
          var $item = $(item);
          var show = false;

          if (filter.length) {
            $.each($item.data('types'), function (typeIndex, typeItem) {
              if (filter.indexOf(typeItem) !== -1) {
                show = true;
              }
            });
          }

          if (show || filter.length === 0) {
            var marker = new ymaps.Placemark([$item.data('lat'), $item.data('lng')], {}, {
              iconLayout: 'default#image',
              iconImageHref: $map.data('icon'),
              iconImageSize: [32, 38],
              iconImageOffset: [-16, -38]
            });
            marker.events.add('click', function () {
              $listScroll.animate({
                scrollTop: $item.offset().top - $list.offset().top + $listScroll.scrollTop() - $list.outerHeight() * (1 / 5)
              }, 400);
              $item.addClass('is-selected');
              map.setCenter([$item.data('lat'), $item.data('lng')]);
              marker.options.set('iconImageHref', $map.data('icon-active'));
              setTimeout(function () {
                $item.removeClass('is-selected');
              }, 2000);
            });
            map.geoObjects.add(marker);
            $item.removeClass('is-hidden');
          } else {
            $item.addClass('is-hidden');
          }
        });

        if (map.geoObjects.getBounds()) {
          map.setBounds(map.geoObjects.getBounds());
        }

        if (map.getZoom() > 15) {
          map.setZoom(15);
        }

        $listScroll.trigger('scroll');
        $list.trigger('resize');
      }; // $list.nanoScroller();
      // $contacts.find('.shops__services__show button').on('click', (e) => {
      // 	e.preventDefault();
      // 	showItems();
      // 	$contacts.find('.shops__services__trigger').removeClass('is-active');
      // 	$contacts.find('.shops__services').removeClass('is-show');
      // });


      $contacts.find('.form__radio label input').on('change', function (e) {
        $contacts.find('.form__radio button').removeClass('is-active');

        if ($(e.currentTarget).is(':checked')) {
          $contacts.find(".js-buy-filter-item[value=\"".concat($(e.currentTarget).val(), "\"]")).prop('checked', true);
        } else {
          $contacts.find(".js-buy-filter-item[value=\"".concat($(e.currentTarget).val(), "\"]")).prop('checked', false);
        }

        showItems();
      });
      $contacts.find('.form__radio button').on('click', function () {
        $contacts.find('.form__radio button').addClass('is-active');
        $contacts.find('.form__radio label input').prop('checked', false);
        showItems();
      });
      app.scriptLoading('//api-maps.yandex.ru/2.1/?lang=ru_RU', function () {
        ymaps.ready(function () {
          map = new ymaps.Map($map.attr('id'), {
            center: [44.496, 34.170],
            zoom: 15,
            controls: []
          }, {});
          showItems();
        });
      });
    }
  },
  scriptLoading: function scriptLoading(src, callback) {
    var script = document.createElement('script');
    var loaded;
    script.setAttribute('src', src);

    if (callback) {
      script.onreadystatechange = script.onload = function () {
        if (!loaded) {
          callback();
        }

        loaded = true;
      };
    }

    document.getElementsByTagName('head')[0].appendChild(script);
  },
  'choice': {
    init: function init($choice) {
      var $pin = $choice.find('.choice__image__pin');
      var $items = $choice.find('.choice__item');
      $pin.on('click', function (e) {
        var $this = $(e.currentTarget);
        var $item = $(".choice__item[data-item=\"".concat($this.data('target'), "\"]")); //e.preventDefault();

        if (!$this.hasClass('is-active')) {
          $items.removeClass('is-active');
          $pin.removeClass('is-active');
          $item.addClass('is-active');
          $this.addClass('is-active');
        }
      });
      $items.on('click', function (e) {
        var $this = $(e.currentTarget);
        var $item = $(".choice__image__pin[data-target=\"".concat($this.data('item'), "\"]")); //e.preventDefault();

        if (!$this.hasClass('is-active')) {
          $items.removeClass('is-active');
          $pin.removeClass('is-active');
          $item.addClass('is-active');
          $this.addClass('is-active');
        }
      });

      if (device.mobile()) {
        var $list = $choice.find('.choice__list__menu ul li a');

        var _$items = $choice.find('.choice__item');

        $choice.find('.choice__list__menu__btn').on('click', function (e) {
          var $this = $(e.currentTarget);
          var $list = $this.closest('.choice__list__menu');
          e.preventDefault();
          $list.toggleClass('is-active-menu');
        });
        $list.on('click', function (e) {
          var $this = $(e.currentTarget);
          var $item = $(".choice__item[data-item=\"".concat($this.data('target'), "\"]"));
          e.preventDefault();

          if (!$this.hasClass('is-active-mob')) {
            _$items.removeClass('is-active-mob');

            $list.removeClass('is-active-mob');
            $item.addClass('is-active-mob');
            $this.addClass('is-active-mob');
          }
        });
        $list.on('click', function (e) {
          var $this = $(e.currentTarget);
          var $item = $this.closest('.choice__list__menu');
          e.preventDefault();
          $item.removeClass('is-active-menu');
        });
      }
    }
  },
  'service-slider': {
    init: function init($parent) {
      var node = $parent.find('.swiper-container')[0];
      var params = {
        roundLengths: true,
        slidesPerView: 'auto',
        spaceBetween: 32,
        loop: false,
        preventClicks: true,
        slidesOffsetAfter: 32,
        breakpoints: {
          768: {
            slidesOffsetBefore: 20,
            slidesOffsetAfter: 20
          }
        }
      };
      var swiper = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a(node, params);
    }
  },
  'order-gate': {
    init: function init($order) {
      $document2.on('click', '.js-order-gate-open', function (e) {
        e.preventDefault();
        $.ajax({
          type: 'get',
          url: $order.data('url'),
          data: {
            id: $(e.currentTarget).data('id')
          },
          dataType: 'json',
          success: function success(response) {
			  console.log(response);
            $order.find('.modal__product').html(response.product);
            $.fancybox.open({
              src: '#order-gate',
              opts: {
                touch: false,
                autoFocus: false,
                backFocus: false
              }
            });
          }
        });
      });
    }
  },
  'card-slider': {
    init: function init($slider) {
      var slider = new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        slidesPerView: 1,
        navigation: {
          prevEl: $slider.find('.card__image__prev')[0],
          nextEl: $slider.find('.card__image__next')[0]
        }
      });
    }
  },
  'sked': {
    init: function init() {
      $document2.on('click', '.js-sked-open', function (e) {
        e.preventDefault();
        $.ajax({
          type: 'get',
          url: $(e.currentTarget).attr('href'),
          success: function success(response) {
            $.fancybox.open(response, {
              touch: false,
              autoFocus: false,
              backFocus: false,
              afterShow: function afterShow() {
                $window.trigger('resize');
              }
            });
            window.initApps();
          }
        });
      });
    }
  },
  'filter': {
    init: function init($filter) {
      var $result = $filter.find('.catalogue__option__result');
      var $optionItem = $filter.find('.js-option-item');
      var $changeItem = null;

      if (device.mobile()) {
        $filter.removeClass('is-active');
        $filter.find('.catalogue__option__drop').css({
          'display': 'none'
        });
      }

      $filter.find('.catalogue__option__title--top').on('click', function (e) {
        var $this = $(e.currentTarget);
        var $parent = $this.closest('.catalogue__option');
        var $drop = $parent.find('.catalogue__option__drop');
        e.preventDefault();
        $parent.toggleClass('is-active');

        if ($parent.hasClass('is-active')) {
          $drop.stop().slideDown(250);
        } else {
          $drop.stop().slideUp(250);
          $filter.removeClass('is-active-filter');
        }
      });
      $optionItem.on('change', function (e) {
        $changeItem = $(e.currentTarget);
      });
      $filter.on('change', function () {
        $filter.removeClass('is-active-filter');
        $.ajax({
          type: 'get',
          url: $result.data('ajax'),
          data: $filter.serialize(),
          dataType: 'json',
          success: function success(result) {
            if ($changeItem) {
              $filter.addClass('is-active-filter');
              $result.css({
                top: $changeItem.offset().top - $filter.offset().top
              }); // $result.attr('href', result.href);
              // $result.find('.catalogue__option__result__text span').text(result.count);
            }
          }
        });
      }); // $result.on('click', (e) => {
      // 	e.preventDefault();
      // 	$(location).attr('href', $result.attr('href'));
      // 	localStorage.confirmFilter = 'yes';
      // });

      if (localStorage.confirmFilter === 'yes') {
        $('html, body').animate({
          scrollTop: $filter.offset().top - 120
        }, 400);
        localStorage.confirmFilter = ' ';
      }
    }
  },
  'media': {
    init: function init($slider) {
      new swiper_dist_js_swiper_js__WEBPACK_IMPORTED_MODULE_2___default.a($slider.find('.swiper-container'), {
        spaceBetween: 25,
        slidesPerView: 5,
        breakpoints: {
          1023: {
            spaceBetween: 15,
            slidesPerView: 'auto'
          }
        }
      });
    }
  },
  'up-btn': {
    init: function init($btn) {
      $window2.on('scroll.upBtn', function () {
        if ($window2.scrollTop() > 100) {
          $btn.addClass('is-show');
        } else {
          $btn.removeClass('is-show');
        }
      }).trigger('scroll');
      $btn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({
          scrollTop: 0
        }, 400);
      });
    }
  }
};
app.global.init();

window.initApps = function () {
  $('[data-app]').each(function (index, item) {
    var $this = $(item);
    var split = $this.data('app').split('||');
    $.each(split, function (appIndex, appName) {
      var appNameCamel = false;

      if (appName.indexOf('-') !== -1) {
        appNameCamel = appName.replace(/(\x2D|[\t-\r \xA0\u1680\u2000-\u200A\u2028\u2029\u202F\u205F\u3000\uFEFF])((?:[\0-\x08\x0E-\x1F!-\x9F\xA1-\u167F\u1681-\u1FFF\u200B-\u2027\u202A-\u202E\u2030-\u205E\u2060-\u2FFF\u3001-\uD7FF\uE000-\uFEFE\uFF00-\uFFFF]|[\uD800-\uDBFF][\uDC00-\uDFFF]|[\uD800-\uDBFF](?![\uDC00-\uDFFF])|(?:[^\uD800-\uDBFF]|^)[\uDC00-\uDFFF]))/g, function (m) {
          return m.toUpperCase();
        }).replace(/\x2D/g, '');
      }

      if (app[appName] && $this.data("".concat(appName, "-init")) !== true) {
        app[appName].init($this);
        $this.data("".concat(appName, "-init"), true);
      } else if (app[appNameCamel] && $this.data("".concat(appName, "-init")) !== true) {
        app[appNameCamel].init($this);
        $this.data("".concat(appName, "-init"), true);
      }
    });
  });
};

initApps();

/***/ }),

/***/ "./src/js/vendor.js":
/*!**************************!*\
  !*** ./src/js/vendor.js ***!
  \**************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_polyfill__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/polyfill */ "./node_modules/@babel/polyfill/lib/index.js");
/* harmony import */ var _babel_polyfill__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_polyfill__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var svg4everybody__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! svg4everybody */ "./node_modules/svg4everybody/dist/svg4everybody.js");
/* harmony import */ var svg4everybody__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(svg4everybody__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_2__);



svg4everybody__WEBPACK_IMPORTED_MODULE_1___default()();
window.$ = jquery__WEBPACK_IMPORTED_MODULE_2___default.a;
window.jQuery = jquery__WEBPACK_IMPORTED_MODULE_2___default.a;

__webpack_require__(/*! ninelines-ua-parser */ "./node_modules/ninelines-ua-parser/dist/ninelines-ua-parser.js");

/***/ })

/******/ });
//# sourceMappingURL=main.js.map
