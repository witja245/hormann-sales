import './vendor';
import './helpers';
import Swiper from 'swiper/dist/js/swiper.js';
import WOW from 'wow.js';
import select2 from 'select2';
import {fancybox} from '@fancyapps/fancybox';
import inputmask from 'inputmask/dist/jquery.inputmask';
import 'jquery-validation';
import '../../node_modules/jquery-validation/dist/localization/messages_ru.js';

jQuery.extend(jQuery.validator.messages, {
	required: 'Поле обязательно для заполнения',
	email: 'Неверный или некорректный e-mail адрес',
});

$.validator.addMethod(
	"regex",
	function (value, element, regexp) {
		if (regexp && regexp.constructor != RegExp) {
			regexp = new RegExp(regexp[0], regexp[1]);
		} else if (regexp.global) regexp.lastIndex = 0;
		return this.optional(element) || regexp.test(value);
	},
	'Поле может содержать только буквы',
);

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
		afterShow: function () {
			conf.nodeBody.addClass('body-state-fancy');

			// this modal parent
			var $thisFancy = $('.fancybox-inner');
			moduleApp.executeModules($thisFancy);

		},
		beforeClose: function () {
			conf.nodeBody.removeClass('body-state-fancy');
		},
		afterClose: function () {
			conf.fancyStatus = false;
		}
	}
};

var moduleApp = {
	'init': function () {
		this.initGlobals();
		this.initGlobalsEvents();
		//this.startupMessage();
		this.executeModules();
		this.loaderImages();
		this.pageLoader();
		this.pagePreLoader();
	},
	'getRandom': function (min, max) {
		return Math.round(min - 0.5 + Math.random() * (max - min + 1));
	},
	'initGlobals': function () {
		$window = $(window);
		$document = $(document);
		$body = $('#body');
		globalXHRStatus = false;
		$window.on('load', function () {
			$window.trigger('resize');
		});
		new WOW().init();
	},
	'initGlobalsEvents': function () {

		var methods = {
			'init': function () {
				methods.getInitialEvents('click');
				methods.getInitialEvents('change');
			},
			'getInitialEvents': function (thisEvent) {
				$document.on(thisEvent, '[data-g' + thisEvent + ']', function (e) {
					e.preventDefault();
					var $this = $(this);
					var thisAction = $this.attr('data-g' + thisEvent);
					var thisValue = $this.val() || $this.data().value;
					if (actions[thisAction]) { actions[thisAction]($this, thisValue); }
					else { console.log('Event: ' + thisEvent + ', Action:"' + thisAction + '" - not defined'); }
				});
			},
			'getTarget': function (thisTarget) {
				return $('[data-target="' + thisTarget + '"]');
			}
		};

		var actions = {

			'toggleMenu': function ($this) {
				$('#ddMenu').toggleClass('is-active');
				$('html').toggleClass('is-show-menu');
			},
			'closeFancy': function () {
				$.fancybox.close();
			},
			'share-page': function ($this, thisValue) {
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
			'scroll-to-anchor': function ($this) {
				var target = $this.attr('href');
				if (target.length) {
					$('html, body').stop().animate({
						scrollTop: $(target).offset().top - 70
					}, 700);
				}
			},
			'scroll-top': function () {
				$('html,body').animate({
					scrollTop: 0
				}, 700);
			}
		};

		methods.init();
	},
	'executeModules': function () {
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
	'pageLoader': function () {
		$body.addClass('jsfx-loaded');
		setTimeout(function () { moduleApp.inViewLoader(); }, 300);
	},
	'pagePreLoader': function () {
		$(".loader_inner").fadeOut();
		$(".loader").delay(100).fadeOut("slow");
	},
	'inViewLoader': function () {
		var hiddenClass = 'view-hidden';
		var $inView = $('.' + hiddenClass);

		$inView.each(function (i, e) {
			var $e = $(e);
			var r1 = parseInt(Math.random() * 1000) + 500;
			var r2 = parseInt(Math.random() * 200);
			var string = 'transition-duration:' + r1 + 'ms;transition-delay:' + r2 + 'ms;transition-property:opacity;';
			var style = $e.attr('style');
			if (style) { string = string + style; }
			$e.attr('style', string);

		});

		$inView.on('inview', function (event, isInView) {
			if (isInView) { $(this).removeClass(hiddenClass); }
		});
	},
	'startupMessage': function () {
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
	'loaderImages': function ($img) {

		var inviewFlag = true;
		if (!$img) { $img = $('[data-img]'); }

		$img.each(function (i, thisImg) {

			var $thisImage = $(thisImg);
			var $parentNode = $thisImage.parent();

			var imgUrl = $thisImage.data().img || '';
			var imgMiddle = $thisImage.data().middle || false;
			var imgVisible = $thisImage.data().visible || false;
			var nativeStyle = $thisImage.attr('style') || '';

			if (!imgVisible) { $thisImage.addClass('sfx-hidden'); }

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
	'index-slider': function ($thisModule) {
		var swiper,
			$parent = $thisModule.find('.swiper-container'),
			$btnPrev = $thisModule.find('.js_btn-prev'),
			$btnNext = $thisModule.find('.js_btn-next'),
			$pager = $thisModule.find('.swiper-pagination');

		swiper = new Swiper($parent, {
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
			},
		})
	},
	'page-slider': function ($thisModule) {
		var swiper,
			$parent = $thisModule.find('.swiper-container'),
			$pager = $thisModule.find('.js-pager');

		swiper = new Swiper($parent, {
			slidesPerView: 'auto',
			spaceBetween: 32,
			breakpoints: {
				1023: {
					spaceBetween: 24,
				},
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
	'advantages-slider': function ($thisModule) {
		var swiper,
			$parent = $thisModule.find('.swiper-container'),
			$pager = $thisModule.find('.js-pager');

		swiper = new Swiper($parent, {
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
				renderBullet: function (index, className) {
					var number;
					if ((index + 1) < 10) {
						number = '0' + (index + 1)
					} else {
						number = index + 1
					}
					return '<span class="' + className + '">' + number + '</span>';
				}
			},
			on: {
				slideChange: function () {
					$('.page-index__about-sect__image').removeClass('is-shown');
					$('.page-index__about-sect__image').eq(this.realIndex).addClass('is-shown');
				}
			}
		});
	},
	'tabs-nav': function ($thisModule, inputConfig) {
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
			'addEvent': function () {
				$navLinks.on('click focus', function (e) {
					e.preventDefault();
					var $this = $(this);
					if (debouncer || $this.hasClass('active')) { return false; }
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
			'changeTab': function (thisIndex) {
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

					$containerBox.find('.swiper-container').each((index, item) => {
						var $item = $(item);
						$item[0].swiper.update();
					})
					$window.trigger('resize');

				}, parseInt(tabsConfig.speed) + 25);
			}
		};

		// init
		tabsCore.addEvent();
		$navLinks.eq(0).addClass('active');
	},
};

var pageApp = {
	'init': function () {
		var curApp = $('#app').attr('data-app');
		if (pageApp[curApp]) { pageApp[curApp](); }
	},
	'page-index': function () {
		console.log('index-here');
	}
};

$(document).ready(function () {
	moduleApp.init();
	// pageApp.init();
});


const $document2 = $(document);
const $window2 = $(window);
const $html = $('html');

let app = {
	'global': {
		init() {
			$('.js-goto').on('click', (e) => {
				let $target = $($(e.currentTarget).data('target') || $(e.currentTarget).attr('href'));

				if ($target.length) {
					e.preventDefault();
					window.scrollTo(0, $target.offset().top - 140);
				}
			});

			$('[data-fancybox]').fancybox({
				backFocus: false,
				touch: false,
				afterShow() {
					$('.fancybox-container:visible .swiper-container').each((index, item) => {
						const $item = $(item);

						if ($item.data('slider')) {
							$item.data('slider').update();
						}
					});
				}
			});

			$('.modal__gif img').hover(
				function() {
					$(this).attr('src', './images/lift-and-turn.gif');
				},
				function() {
					$(this).attr('src', './images/lift-and-turn-static.gif');
				}
			);

			app.sked.init();
		},
	},
	'header': {
		init($header) {
			$header.find('.is-header__location').on('click', (e) => {
				let $this = $(e.currentTarget);
				let $parent = $this.closest('.is-header__left');
				let $drop = $parent.find('.is-header__location__drop');

				e.preventDefault();
				$parent.toggleClass('is-show-geo');
				if ($parent.hasClass('is-show-geo')) {
					$drop.stop().slideDown(250);
				} else {
					$drop.stop().slideUp(250);
				}
			});

			$header.find('.is-header__location__drop__btns__yes').on('click', (e) => {
				e.preventDefault();
				localStorage.confirmLocation = 'yes';
				$header.find('.is-header__left').removeClass('is-show-geo');
				$header.find('.is-header__location__drop').stop().slideUp(250);
			});

			$document2.on('click', (e) => {
				let $target = $(e.target);
				if (!$target.closest('.is-header__left.is-show-geo').length) {
					$header.find('.is-header__left.is-show-geo .is-header__location__drop').stop().slideUp(250);
					$header.find('.is-header__left.is-show-geo').removeClass('is-show-geo');
				}
			});

			$header.addClass('animated');

			$window2.on('scroll', () => {
				if ($window2.scrollTop() > 0) {
					$header.addClass('is-fixed');
				} else {
					$header.removeClass('is-fixed');
				}
			});
		},
	},
	'dd-menu': {
		init($menu) {
			if (device.mobile()) {
				$menu.find('.dd-menu__nav-item__arrow').on('click', (e) => {
					let $this = $(e.currentTarget);
					let $item = $this.closest('.dd-menu__nav li');
					let $drop = $item.find('.header-nav__item__drop');

					e.preventDefault();
					$item.toggleClass('is-active');
					if ($item.hasClass('is-active')) {
						$drop.stop().slideDown(250);
					} else {
						$drop.stop().slideUp(250);
					}
				});
			}
		},
	},
	'geo': {
		init($geo) {
			let checkFill = () => {
				if ($geo.find('.modal__select select').val()) {
					$geo.addClass('is-filled');
				} else {
					$geo.removeClass('is-filled');
				}
			};

			document.querySelectorAll('.modal-geo a').forEach(function (link, index) {
				link.addEventListener('click', function (e) {
					e.preventDefault()
					let city = link.getAttribute('href').replace('?set-city=', '')
					$.ajax({
						type: 'post',
						url: '/ajax/set_city.php',
						data: {
							city: city
						},
						success: function(result) {
							console.log(result)
							document.querySelector('.is-header__location-div span').textContent = city
							$.fancybox.close()
						},
					});
				})
			})


			$geo.find('.modal__select select').on('change', () => {
				localStorage.confirmLocation = 'yes';
			});

			$geo.find('.modal__city a').on('click', (e) => {
				e.preventDefault()
				localStorage.confirmLocation = 'yes';
			});

			$geo.find('.modal__select select').select2({
				dropdownParent: $geo.find('.modal__select'),

				ajax: {
					url: $geo.find('.modal__select').data('geo'),
					dataType: 'json',
				},
			});

			checkFill();
			$geo.on('change', () => {
				checkFill();
			});
		},
	},
	'edge': {
		init($slider) {
			let numbers = new Swiper($slider.find('.edge__number .swiper-container'), {
				slidesPerView: 'auto',
				spaceBetween: 8,
				allowTouchMove: false,
			});

			let inner = new Swiper($slider.find('.edge__inner .swiper-container'), {
				slidesPerView: 1,
				spaceBetween: 16,
				loop: true,
				speed: 800,
				autoplay: {
					delay: 4000,
					disableOnInteraction: false,
				},
				on: {
					slideChange: function () {
						$slider.find('.edge__image img').removeClass('is-shown');
						$slider.find('.edge__image img').eq(this.realIndex).addClass('is-shown');
					}
				},
				thumbs: {
					swiper: numbers,
				},
			});

			$window2.on('load', () => {
				numbers.update();
				inner.update();
			});
		},
	},
	'slider-item': {
		init($slider) {
			if ($slider.find('.swiper-slide').length < 2) {
				$slider.find('.slider__pager').hide();
			}

			new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 32,
				slidesPerView: 'auto',
				allowTouchMove: $slider.find('.swiper-slide').length < 2 ? false : true,
				breakpoints: {
					1023: {
						spaceBetween: 25,
					},
				},
				pagination: {
					el: $slider.find('.slider__pager')[0],
					clickable: true
				},
			});
		},
	},
	'slider-list': {
		init($slider) {
			let slider = new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 32,
				slidesPerView: 1,
				breakpoints: {
					1023: {
						spaceBetween: 25,
						slidesPerView: 'auto',
					},
				},
				pagination: {
					el: $slider.find('.slider__pager')[0],
					clickable: true
				},
			});
		},
	},
	'slider-videos': {
		init($slider) {
			new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 32,
				slidesPerView: 2,
				breakpoints: {
					1023: {
						spaceBetween: 25,
						slidesPerView: 'auto',
					},
				},
				pagination: {
					el: $slider.find('.slider__pager')[0],
					clickable: true
				},
			});
		},
	},
	'slider-goods': {
		init($slider) {
			new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 32,
				slidesPerView: 3,
				breakpoints: {
					1023: {
						spaceBetween: 25,
						slidesPerView: 'auto',
					},
				},
				pagination: {
					el: $slider.find('.slider__pager')[0],
					clickable: true
				},
			});
		},
	},
	'slider-educ': {
		init($slider) {
			new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 32,
				slidesPerView: 2,
				breakpoints: {
					1023: {
						spaceBetween: 25,
						slidesPerView: 'auto',
					},
				},
			});
		},
	},
	'slider-create': {
		init($slider) {
			new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 16,
				slidesPerView: 1,
				navigation: {
					prevEl: $slider.find('.create__slider__arrow_prev')[0],
					nextEl: $slider.find('.create__slider__arrow_next')[0],
				},
				pagination: {
					el: $slider.find('.create__slider__pager')[0],
					type: 'fraction',
					formatFractionCurrent(number) {
						return number < 10 ? `${number}` : number;
					},
					formatFractionTotal(number) {
						return number < 10 ? `${number}` : number;
					},
				},
			});
		},
	},
	'slider-sked': {
		init($slider) {
			let slider = new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 16,
				slidesPerView: 1,
				navigation: {
					prevEl: $slider.find('.modal__slider__arrow_prev')[0],
					nextEl: $slider.find('.modal__slider__arrow_next')[0],
				},
				pagination: {
					el: $slider.find('.modal__slider__pager')[0],
					type: 'fraction',
					formatFractionCurrent(number) {
						return number < 10 ? `${number}` : number;
					},
					formatFractionTotal(number) {
						return number < 10 ? `${number}` : number;
					},
				},
			});

			$slider.find('.swiper-container').data('slider', slider)
		},
	},
	'slider-images': {
		init($slider) {
			new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 32,
				slidesPerView: 3,
				breakpoints: {
					1023: {
						spaceBetween: 25,
						slidesPerView: 'auto',
					},
				},
				pagination: {
					el: $slider.find('.slider__pager')[0],
					clickable: true
				},
			});
		},
	},
	'slider-advice': {
		init($slider) {
			let slider = new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 32,
				slidesPerView: 3,
				breakpoints: {
					1023: {
						spaceBetween: 25,
						slidesPerView: 'auto',
					},
				},
				pagination: {
					el: $slider.find('.slider__pager')[0],
					clickable: true
				},
			});
		},
	},
	'slider-leveler-platforms': {
		init($slider) {
			let slider = new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 32,
				slidesPerView: 2,
				breakpoints: {
					1023: {
						spaceBetween: 25,
						slidesPerView: 'auto',
					},
				},
				pagination: {
					el: $slider.find('.slider__pager')[0],
					clickable: true
				},
			});
		},
	},
	'story': {
		init($story) {
			let $slider = $story.find('.slider');
			let $list = $story.find('.story__tabs__list ul li a');
			let $items = $story.find('.story__tabs__item');

			new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 32,
				slidesPerView: 3,
				breakpoints: {
					1023: {
						spaceBetween: 25,
						slidesPerView: 'auto',
					},
				},
			});

			$list.on('click', (e) => {
				let $this = $(e.currentTarget);
				let $item = $(`.story__tabs__item[data-item="${$this.data('target')}"]`);

				e.preventDefault();
				if (!$this.hasClass('is-active')) {
					$items.removeClass('is-active');
					$list.removeClass('is-active');
					$item.addClass('is-active');
					$this.addClass('is-active');
				}
			});
		},
	},
	'make': {
		init($make) {
			let $list = $make.find('.make__list ul li a');
			let $items = $make.find('.make__item');

			$list.on('click', (e) => {
				let $this = $(e.currentTarget);
				let $item = $(`.make__item[data-item="${$this.data('target')}"]`);

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

			$make.find('.make__item').each((index, item) => {
				let $item = $(item);

				let slider = new Swiper($item.find('.swiper-container'), {
					spaceBetween: 16,
					slidesPerView: 1,
					navigation: {
						prevEl: $item.find('.make__slider__arrow_prev')[0],
						nextEl: $item.find('.make__slider__arrow_next')[0],
					},
					pagination: {
						el: $item.find('.make__slider__pager')[0],
						type: 'fraction',
						formatFractionCurrent(number) {
							return number < 10 ? `${number}` : number;
						},
						formatFractionTotal(number) {
							return number < 10 ? `${number}` : number;
						},
					},
				});

				$item.find('.swiper-container').data('slider', slider);
			});
		},
	},
	'catalog-filter': {
		init($filter) {
			let $list = $filter.find('.catalog__filter__option button');
			let $items = $filter.find('.catalog__filter__opt');

			$filter.find('.btn-parameters').on('click', (e) => {
				let $drop = $filter.find('.catalog__filter__drop');

				e.preventDefault();
				$drop.toggleClass('is-show')
				if ($drop.hasClass('is-show')) {
					$drop.stop().slideDown(250);
				} else {
					$drop.stop().slideUp(250);
				}
			})

			$list.on('click', (e) => {
				let $this = $(e.currentTarget);
				let $item = $(`.catalog__filter__opt[data-item="${$this.data('target')}"]`);

				e.preventDefault();
				if (!$this.hasClass('is-active')) {
					$items.removeClass('is-active');
					$list.removeClass('is-active');
					$item.addClass('is-active');
					$this.addClass('is-active');
				}
			});
		},
	},
	'select': {
		init($select) {
			let checkFill = () => {
				if ($select.find('select').val()) {
					$select.addClass('is-filled');
				} else {
					$select.removeClass('is-filled');
				}
			};
			$select.find('select').select2({
				minimumResultsForSearch: Infinity,
				dropdownParent: $select,
			});
			checkFill();
			$select.on('change', () => {
				checkFill();
			});
		},
	},
	'catalogue-more': {
		init($catalogue) {
			$catalogue.find('.catalogue__option__more button').on('click', (e) => {
				let $this = $(e.currentTarget);
				let $drop = $catalogue.find('.checkbox-drop');

				e.preventDefault();
				$this.addClass('is-hidden');
				$drop.addClass('is-active');
			})
		},
	},
	'accordion': {
		init($accordion) {
			$accordion.find('.title-text').on('click', (e) => {
				let $this = $(e.currentTarget);
				let $item = $this.closest('.accordion__item');
				let $drop = $item.find('.accordion__drop');

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
		},
	},
	'form': {
		init($form) {
			let validator = $form.validate({
				lang: 'ru',
				rules: {},

				submitHandler(form) {
					if ($form.data('type') === 'submit') {
						form.submit();
					} else {
						let preparedData;
						let processData;
						let contentType;

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
							processData,
							contentType,
							success(result) {
								if (result.result === true) {
									$form[0].reset();
									$form.find('.form__file__title').text('Приложите файл');
									$.fancybox.close();
								}
								$.fancybox.open(`<div class="modal modal-alert">
									<div class="modal__alert">${result.message}</div>
								</div>`, {
									touch: false,
									autoFocus: false,
								});
							},
						});
					}
				},
			});

			setTimeout(() => {
				$form.find('[data-validation]').each((index, item) => {
					$(item).rules('add', $(item).data('validation'));
				});
			}, 1000);

			$form.find('.form__file input').on('change', (e) => {
				let $this = $(e.currentTarget);
				let $file = $this.closest('.form__file');
				let $text = $this.closest('.form__file').find('.form__file__title');

				if (e.target.files.length === 0) {
					$text.text($text.data('text'));
					$file.removeClass('is-file-selected');
				} else if (e.target.files.length === 1) {
					$text.text(e.target.files[0].name);
					$file.addClass('is-file-selected');
				} else {
					$text.text(`${$text.data('multiple') || 'Files count:'} ${e.target.files.length}`);
					$file.addClass('is-file-selected');
				}
				$(e.currentTarget).valid();
			});
		}
	},
	'mask': {
		init($mask) {
			$mask.inputmask($mask.data('mask').toString(), {
				showMaskOnHover: false,
				clearIncomplete: true,
			});
		},
	},
	'contacts': {
		init($contacts) {
			let $items = $contacts.find('.contacts__item');
			let $map = $contacts.find('.contacts__map');
			let map;
			let $list = $contacts.find('.contacts__list');
			let $listScroll = $contacts.find('.contacts__list__scroll');
			let filter = [];
			let markers = [];

			let collectFilter = () => {
				filter = [];

				$contacts.find('.form__radio input:checked').each((index, item) => {
					filter.push($(item).val());
				});
			};

			let showItems = () => {
				map.geoObjects.removeAll();

				collectFilter();
				$items.each((index, item) => {
					let $item = $(item);
					let show = false;

					if (filter.length) {
						$.each($item.data('types'), (typeIndex, typeItem) => {
							if (filter.indexOf(typeItem) !== -1) {
								show = true;
							}
						});
					}

					if (show || filter.length === 0) {
						let marker = new ymaps.Placemark([$item.data('lat'), $item.data('lng')], {}, {
							iconLayout: 'default#image',
							iconImageHref: $map.data('icon'),
							iconImageSize: [32, 38],
							iconImageOffset: [-16, -38],
						});

						marker.events.add('click', () => {
							$listScroll.animate({
								scrollTop: $item.offset().top - $list.offset().top + $listScroll.scrollTop() - ($list.outerHeight() * (1 / 5)),
							}, 400);
							$item.addClass('is-selected');

							map.setCenter([$item.data('lat'), $item.data('lng')]);
							marker.options.set('iconImageHref', $map.data('icon-active'));

							setTimeout(() => {
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
			};

			// $list.nanoScroller();

			// $contacts.find('.shops__services__show button').on('click', (e) => {
			// 	e.preventDefault();
			// 	showItems();
			// 	$contacts.find('.shops__services__trigger').removeClass('is-active');
			// 	$contacts.find('.shops__services').removeClass('is-show');
			// });

			$contacts.find('.form__radio label input').on('change', (e) => {
				$contacts.find('.form__radio button').removeClass('is-active');

				if ($(e.currentTarget).is(':checked')) {
					$contacts.find(`.js-buy-filter-item[value="${$(e.currentTarget).val()}"]`).prop('checked', true)
				}
				else {
					$contacts.find(`.js-buy-filter-item[value="${$(e.currentTarget).val()}"]`).prop('checked', false)
				}
				showItems();
			});

			$contacts.find('.form__radio button').on('click', () => {
				$contacts.find('.form__radio button').addClass('is-active');
				$contacts.find('.form__radio label input').prop('checked', false);
				showItems();
			});

			app.scriptLoading('//api-maps.yandex.ru/2.1/?lang=ru_RU', () => {
				ymaps.ready(() => {
					map = new ymaps.Map($map.attr('id'), {
						center: [44.496, 34.170],
						zoom: 15,
						controls: [],
					}, {});

					showItems();
				});
			});
		},
	},
	scriptLoading(src, callback) {
		let script = document.createElement('script');
		let loaded;

		script.setAttribute('src', src);
		if (callback) {
			script.onreadystatechange = script.onload = () => {
				if (!loaded) {
					callback();
				}
				loaded = true;
			};
		}
		document.getElementsByTagName('head')[0].appendChild(script);
	},
	'choice': {
		init($choice) {
			let $pin = $choice.find('.choice__image__pin');
			let $items = $choice.find('.choice__item');

			$pin.on('click', (e) => {
				let $this = $(e.currentTarget);
				let $item = $(`.choice__item[data-item="${$this.data('target')}"]`);

				//e.preventDefault();
				if (!$this.hasClass('is-active')) {
					$items.removeClass('is-active');
					$pin.removeClass('is-active');
					$item.addClass('is-active');
					$this.addClass('is-active');
				}
			});

			$items.on('click', (e) => {
				let $this = $(e.currentTarget);
				let $item = $(`.choice__image__pin[data-target="${$this.data('item')}"]`);

				//e.preventDefault();
				if (!$this.hasClass('is-active')) {
					$items.removeClass('is-active');
					$pin.removeClass('is-active');
					$item.addClass('is-active');
					$this.addClass('is-active');
				}
			});

			if (device.mobile()) {
				let $list = $choice.find('.choice__list__menu ul li a');
				let $items = $choice.find('.choice__item');

				$choice.find('.choice__list__menu__btn').on('click', (e) => {
					let $this = $(e.currentTarget);
					let $list = $this.closest('.choice__list__menu');

					e.preventDefault();
					$list.toggleClass('is-active-menu');
				});

				$list.on('click', (e) => {
					let $this = $(e.currentTarget);
					let $item = $(`.choice__item[data-item="${$this.data('target')}"]`);

					e.preventDefault();
					if (!$this.hasClass('is-active-mob')) {
						$items.removeClass('is-active-mob');
						$list.removeClass('is-active-mob');
						$item.addClass('is-active-mob');
						$this.addClass('is-active-mob');
					}
				});

				$list.on('click', (e) => {
					let $this = $(e.currentTarget);
					let $item = $this.closest('.choice__list__menu');

					e.preventDefault();
					$item.removeClass('is-active-menu');
				});
			}
		},
	},
	'service-slider':{
		init($parent){
			let node = $parent.find('.swiper-container')[0];
			let params = {
				roundLengths: true,
                slidesPerView: 'auto',
                spaceBetween: 32,
                loop: false,
                preventClicks: true,
                slidesOffsetAfter: 32,
				breakpoints:{
                    768:{
                        slidesOffsetBefore: 20,
                        slidesOffsetAfter: 20,
					}
				}
			};

            let swiper = new Swiper(node, params);
		}
	},
	'order-gate': {
		init($order) {
			$document2.on('click', '.js-order-gate-open', (e) => {
				e.preventDefault();
				$.ajax({
					type: 'get',
					url: $order.data('url'),
					data: {
						id: $(e.currentTarget).data('id'),
					},
					dataType: 'json',
					success(response) {
						$order.find('.modal__product').html(response.product);
						$.fancybox.open({
							src: '#order-gate',
							opts: {
								touch: false,
								autoFocus: false,
								backFocus: false,
							},
						});
					},
				});
			});
		},
	},
	'card-slider': {
		init($slider) {
			let slider = new Swiper($slider.find('.swiper-container'), {
				slidesPerView: 1,
				navigation: {
					prevEl: $slider.find('.card__image__prev')[0],
					nextEl: $slider.find('.card__image__next')[0],
				},
			});
		},
	},
	'sked': {
		init() {
			$document2.on('click', '.js-sked-open', (e) => {
				e.preventDefault();
				$.ajax({
					type: 'get',
					url: $(e.currentTarget).attr('href'),
					success(response) {
						$.fancybox.open(response, {
							touch: false,
							autoFocus: false,
							backFocus: false,
							afterShow() {
								$window.trigger('resize');
							},
						});
						window.initApps();
					},
				});
			});
		},
	},
	'filter': {
		init($filter) {
			const $result = $filter.find('.catalogue__option__result');
			const $optionItem = $filter.find('.js-option-item');
			let $changeItem = null;

			if (device.mobile()) {
				$filter.removeClass('is-active');
				$filter.find('.catalogue__option__drop').css({'display': 'none'});
			}

			$filter.find('.catalogue__option__title--top').on('click', (e) => {
				let $this = $(e.currentTarget);
				let $parent = $this.closest('.catalogue__option');
				let $drop = $parent.find('.catalogue__option__drop');

				e.preventDefault();
				$parent.toggleClass('is-active');
				if ($parent.hasClass('is-active')) {
					$drop.stop().slideDown(250);
				} else {
					$drop.stop().slideUp(250);
					$filter.removeClass('is-active-filter');
				}
			});

			$optionItem.on('change', (e) => {
				$changeItem = $(e.currentTarget);
			});

			$filter.on('change', () => {
				$filter.removeClass('is-active-filter');

				$.ajax({
					type: 'get',
					url: $result.data('ajax'),
					data: $filter.serialize(),
					dataType: 'json',
					success(result) {
						if ($changeItem) {
							$filter.addClass('is-active-filter');
							$result.css({
								top: $changeItem.offset().top - $filter.offset().top,
							});
							// $result.attr('href', result.href);
							// $result.find('.catalogue__option__result__text span').text(result.count);
						}
					},
				});
			});

			// $result.on('click', (e) => {
			// 	e.preventDefault();
			// 	$(location).attr('href', $result.attr('href'));
			// 	localStorage.confirmFilter = 'yes';
			// });

			if (localStorage.confirmFilter === 'yes') {
				$('html, body').animate({
					scrollTop: $filter.offset().top - 120,
				}, 400)

				localStorage.confirmFilter = ' ';
			}
		},
	},
	'media': {
		init($slider) {
			new Swiper($slider.find('.swiper-container'), {
				spaceBetween: 25,
				slidesPerView: 5,
				breakpoints: {
					1023: {
						spaceBetween: 15,
						slidesPerView: 'auto',
					},
				},
			});
		},
	},
	'up-btn': {
		init($btn) {
			$window2.on('scroll.upBtn', () => {
				if ($window2.scrollTop() > 100) {
					$btn.addClass('is-show');
				} else {
					$btn.removeClass('is-show');
				}
			}).trigger('scroll');

			$btn.on('click', (e) => {
				e.preventDefault();
				$('html, body').animate({
					scrollTop: 0,
				}, 400);
			});
		},
	},
};

app.global.init();

window.initApps = () => {
	$('[data-app]').each((index, item) => {
		let $this = $(item);
		let split = $this.data('app').split('||');

		$.each(split, (appIndex, appName) => {
			let appNameCamel = false;

			if (appName.indexOf('-') !== -1) {
				appNameCamel = appName.replace(/(-|\s)(\S)/ug, (m) => m.toUpperCase()).replace(/-/ug, '');
			}

			if (app[appName] && $this.data(`${appName}-init`) !== true) {
				app[appName].init($this);
				$this.data(`${appName}-init`, true);
			} else if (app[appNameCamel] && $this.data(`${appName}-init`) !== true) {
				app[appNameCamel].init($this);
				$this.data(`${appName}-init`, true);
			}
		});
	});
};

initApps();
