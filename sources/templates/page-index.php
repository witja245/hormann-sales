<? include($_SERVER["DOCUMENT_ROOT"] . '/dist/include/header-homepage.php'); ?>

<main class="page-index">
	<div class="index-hero wow">
		<div class="index-hero__container" data-is="index-slider">
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="index-hero__item">
							<div class="index-hero__image swiper-lazy" data-background="/img/tpl01.jpg"></div>
							<div class="index-hero__content-wrapper">
								<div class="index-hero__content wrapper wrapper--md">
									<div class="index-hero__content-inner">
										<div class="b-label">Официальный сайт</div>
										<h1 class="h1 index-hero__title">Крупнейший в Европе производитель гаражных ворот, дверей и приводов</h1>
										<p class="index-hero__small-text">с 1935 года</p>
									</div>
								</div>
							</div>
						</div>
						<div class="swiper-lazy-preloader"></div>
					</div>
					<div class="swiper-slide">
						<div class="index-hero__item">
							<div class="index-hero__image swiper-lazy" data-background="/img/tpl02.jpg"></div>
							<div class="index-hero__content-wrapper">
								<div class="index-hero__content wrapper wrapper--md">
									<div class="index-hero__content-inner">
										<div class="b-label">Какой-то текст</div>
										<div class="h1 index-hero__title">Длинный заголовок из нескольких слов</div>
										<p class="index-hero__small-text">текст поменьше в одну или две строки</p>
									</div>
								</div>
							</div>
						</div>
						<div class="swiper-lazy-preloader"></div>
					</div>
				</div>
				<div class="swiper-pagination"></div>
				<div class="b-arr-nav index-hero__nav">
					<div class="b-arr-nav__btn b-arr-nav__btn--prev js_btn-prev">
						<svg width="16" height="16">
							<use xlink:href="#arrow" class="arr"></use>
						</svg>
					</div>
					<div class="b-arr-nav__btn b-arr-nav__btn--next js_btn-next">
						<svg width="16" height="16">
							<use xlink:href="#arrow" class="arr"></use>
						</svg>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class="is-section wow" data-wow-offset="100">
		<div class="wrapper wrapper--md">
			<div class="is-tabs is-tabs__nav" data-is="tabs-nav" data-tab-body="tabs-body-a">
				<span class="is-tabs__link is-link" tabindex="0" role="button">
					Для дома
				</span>
				<span class="is-tabs__link is-link" tabindex="0" role="button">
					Для бизнеса
				</span>
			</div>
		</div>
		<div class="is-tabs is-tabs__container tabs-body-a">
			<div class="is-tabs__wrapper">
				<div class="is-tabs__tab">
					<div class="page-slider" data-is="page-slider">
						<div class="wrapper-x-right-dir">
							<div class="swiper-container">
								<div class="swiper-wrapper">
									<div class="swiper-slide">
										<div class="page-slider__slide page-slider__slide--type1">
											<a href="#" class="item is-link" data-img="/img/tpl02.jpg" data-img-fast="1">
												<span class="page-slider__slide-ttl">Гаражные<br>ворота</span>
											</a>
											<a href="#" class="item is-link" data-img="/img/tpl03.jpg" data-img-fast="1">
												<span class="page-slider__slide-ttl">Входные<br>двери</span>
											</a>
											<a href="#" class="item is-link" data-img="/img/tpl04.jpg" data-img-fast="1">
												<span class="page-slider__slide-ttl">Умный<br>дом</span>
												<span class="page-slider__slide-label b-label">Скоро</span>
											</a>
										</div>
									</div>
									<div class="swiper-slide">
										<div class="page-slider__slide page-slider__slide--type2">
											<a href="#" class="item is-link" data-img="/img/tpl03.jpg" data-img-fast="1">
												<span class="page-slider__slide-ttl">Межкомнатные<br>двери</span>
											</a>
											<a href="#" class="item is-link" data-img="/img/tpl01.jpg" data-img-fast="1"></a>
											<a href="#" class="item is-link" data-img="/img/tpl02.jpg" data-img-fast="1"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="wrapper wrapper--md">
							<div class="swiper-pagination js-pager"></div>
						</div>
					</div>
				</div>
				<div class="is-tabs__tab">
					<div class="page-slider" data-is="page-slider">
						<div class="wrapper-x-right-dir">
							<div class="swiper-container">
								<div class="swiper-wrapper">
									<div class="swiper-slide">
										<div class="page-slider__slide page-slider__slide--type2">
											<a href="#" class="item is-link"></a>
											<a href="#" class="item is-link"></a>
											<a href="#" class="item is-link"></a>
										</div>
									</div>
									<div class="swiper-slide">
										<div class="page-slider__slide page-slider__slide--type1">
											<a href="#" class="item is-link"></a>
											<a href="#" class="item is-link"></a>
											<a href="#" class="item is-link"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="wrapper wrapper--md">
							<div class="swiper-pagination js-pager"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="is-section wow" data-wow-offset="200">
		<div class="wrapper wrapper--sm">
			<a href="#" class="is-link">
				<div class="is-columns b-offer b-offer--type1">
					<div class="col b-offer__text-cont">
						<span class="b-label">Акция до 31 декабря</span>
						<div class="b-offer__text-block">
							<div class="b-offer__title">Ворота и двери года</div>
							<p class="b-offer__text">Выгодное предложение на внутренние, сверхпрочные двери ZK для дома и административных помещений.</p>
						</div>
					</div>
					<div class="col b-offer__img">
                        <div class="b-offer__img__block" style="background-image:url(/img/tpl05.jpg)"></div>
                    </div>
				</div>
			</a>
		</div>
	</section>

	<section class="is-section page-index__about-sect wow" data-wow-offset="200">
		<img class="page-index__about-sect__image" id="asi-one" src="/img/01-bitmap.jpg">
		<img class="page-index__about-sect__image" id="asi-two" src="/img/02-bitmap.jpg">
		<img class="page-index__about-sect__image" id="asi-three" src="/img/03-bitmap.jpg">
		<div class="wrapper wrapper--sm">
			<div class="is-grid">
				<div class="is-grid__item">
					<div class="h2 title">Hörmann — качество<br> без компромиссов</div>
					<p class="is-text">
						Hörmann — единственный производитель на международном рынке, предлагающий «из одних рук» все основные строительные элементы, которые изготавливаются на высокоспециализированных предприятиях в соответствии с новейшими техническими достижениями. Имея широкую торговую и сервисную сеть в Европе и представительства в Америке и Азии, Hörmann является надежным поставщиком высококачественных строительных конструкций.
					</p>
					<a href="#" class="is-link is-link--has-arrow">О компании</a>
				</div>
				<div class="is-grid__item">
					<div class="page-index__advantages-about">
						<div class="advantages-slider" data-is="advantages-slider">
							<div class="swiper-container">
								<div class="js-pager advantages-slider__pager"></div>
								<div class="swiper-wrapper">
									<div class="swiper-slide advantages-slider__slide">
										<img data-img="/img/adv-logo01.png" alt="" class="responsive-img advantages-slider__logo">
										<div class="advantages-slider__text-cont">
											<div class="h4 advantages-slider__slide-title">Компания с мировым именем — в России с 1997 года</div>
											<p class="advantages-slider__slide-text">
												Крупнейший немецкий концерн с мировой известностью. С 1935 года корпорация Hormann выпустила более 15 миллионов ворот
											</p>
										</div>
									</div>
									<div class="swiper-slide advantages-slider__slide">
										<img data-img="/img/adv-logo02.png" alt="" class="responsive-img advantages-slider__logo">
										<div class="advantages-slider__text-cont">
											<div class="h4 advantages-slider__slide-title">Быстрая поставка оборудования</div>
											<p class="advantages-slider__slide-text">
												Широкий спектр запасных частей на региональных складах
											</p>
										</div>
									</div>
									<div class="swiper-slide advantages-slider__slide">
										<img data-img="/img/adv-logo03.png" alt="" class="responsive-img advantages-slider__logo">
										<div class="advantages-slider__text-cont">
											<div class="h4 advantages-slider__slide-title">Сервисное обслуживание и ремонт от производителя</div>
											<p class="advantages-slider__slide-text">
												Оцените сервисное обслуживание высочайшего уровня
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="is-section is-section--colored page-index__advice-sect wow" data-wow-offset="200">
		<div class="wrapper wrapper--md">
			<div class="b-grid-pattern">
				<div class="b-grid-pattern__header">
					<div class="b-grid-pattern__h-left">
						<div class="h2 b-grid-pattern__h-title">Советы от Hörmann</div>
					</div>
					<div class="b-grid-pattern__h-right">
						<a href="#" class="is-link is-link--has-icon">
							<svg fill="#003a7d" height="15" viewBox="0 0 15 15" width="15" xmlns="http://www.w3.org/2000/svg"><path d="m.666667.333333h2.666663c.18667 0 .34223.066667.46667.2.13333.124444.2.28.2.466667v2.66667c0 .18666-.06667.34666-.2.48-.12444.12444-.28.18666-.46667.18666h-2.666663c-.186667 0-.346667-.06222-.48-.18666-.1244448-.13334-.186667-.29334-.186667-.48v-2.66667c0-.186667.0622222-.342223.186667-.466667.133333-.133333.293333-.2.48-.2zm5.333333 0h2.66667c.18666 0 .34222.066667.46666.2.13334.124444.2.28.2.466667v2.66667c0 .18666-.06666.34666-.2.48-.12444.12444-.28.18666-.46666.18666h-2.66667c-.18667 0-.34667-.06222-.48-.18666-.12444-.13334-.18667-.29334-.18667-.48v-2.66667c0-.186667.06223-.342223.18667-.466667.13333-.133333.29333-.2.48-.2zm5.3333 0h2.6667c.1867 0 .3422.066667.4667.2.1333.124444.2.28.2.466667v2.66667c0 .18666-.0667.34666-.2.48-.1245.12444-.28.18666-.4667.18666h-2.6667c-.1866 0-.3466-.06222-.48-.18666-.1244-.13334-.1866-.29334-.1866-.48v-2.66667c0-.186667.0622-.342223.1866-.466667.1334-.133333.2934-.2.48-.2zm-10.666633 5.333337h2.666663c.18667 0 .34223.06666.46667.2.13333.12444.2.28.2.46666v2.66667c0 .18667-.06667.34667-.2.48-.12444.12444-.28.18667-.46667.18667h-2.666663c-.186667 0-.346667-.06223-.48-.18667-.1244448-.13333-.186667-.29333-.186667-.48v-2.66667c0-.18666.0622222-.34222.186667-.46666.133333-.13334.293333-.2.48-.2zm5.333333 0h2.66667c.18666 0 .34222.06666.46666.2.13334.12444.2.28.2.46666v2.66667c0 .18667-.06666.34667-.2.48-.12444.12444-.28.18667-.46666.18667h-2.66667c-.18667 0-.34667-.06223-.48-.18667-.12444-.13333-.18667-.29333-.18667-.48v-2.66667c0-.18666.06223-.34222.18667-.46666.13333-.13334.29333-.2.48-.2zm5.3333 0h2.6667c.1867 0 .3422.06666.4667.2.1333.12444.2.28.2.46666v2.66667c0 .18667-.0667.34667-.2.48-.1245.12444-.28.18667-.4667.18667h-2.6667c-.1866 0-.3466-.06223-.48-.18667-.1244-.13333-.1866-.29333-.1866-.48v-2.66667c0-.18666.0622-.34222.1866-.46666.1334-.13334.2934-.2.48-.2zm-10.666633 5.33333h2.666663c.18667 0 .34223.0667.46667.2.13333.1244.2.28.2.4667v2.6666c0 .1867-.06667.3467-.2.48-.12444.1245-.28.1867-.46667.1867h-2.666663c-.186667 0-.346667-.0622-.48-.1867-.1244448-.1333-.186667-.2933-.186667-.48v-2.6666c0-.1867.0622222-.3423.186667-.4667.133333-.1333.293333-.2.48-.2zm5.333333 0h2.66667c.18666 0 .34222.0667.46666.2.13334.1244.2.28.2.4667v2.6666c0 .1867-.06666.3467-.2.48-.12444.1245-.28.1867-.46666.1867h-2.66667c-.18667 0-.34667-.0622-.48-.1867-.12444-.1333-.18667-.2933-.18667-.48v-2.6666c0-.1867.06223-.3423.18667-.4667.13333-.1333.29333-.2.48-.2zm5.3333 0h2.6667c.1867 0 .3422.0667.4667.2.1333.1244.2.28.2.4667v2.6666c0 .1867-.0667.3467-.2.48-.1245.1245-.28.1867-.4667.1867h-2.6667c-.1866 0-.3466-.0622-.48-.1867-.1244-.1333-.1866-.2933-.1866-.48v-2.6666c0-.1867.0622-.3423.1866-.4667.1334-.1333.2934-.2.48-.2z" fill="#003a7d"/></svg>
							<span>Смотреть все</span>
						</a>
					</div>
				</div>
				<div class="b-grid-pattern__body">
					<div class="is-grid">
						<div class="is-grid__item">
							<div class="b-grid-pattern__item">
								<a href="#" class="b-grid-pattern__i-img is-link" data-img="/img/tpl06.jpg"></a>
								<a href="#" class="b-grid-pattern__i-text is-link">
									<p>
										<b>Изоляция гаража.</b> Чем выгодны для Вас гаражные ворота с теплоизоляцией?
									</p>
								</a>
							</div>
						</div>
						<div class="is-grid__item">
							<div class="b-grid-pattern__item">
								<a href="#" class="b-grid-pattern__i-img is-link" data-img="/img/tpl07.jpg"></a>
								<a href="#" class="b-grid-pattern__i-text is-link">
									<p>
										<b>Сравнение входных дверей.</b> Из каких материалов производятся входные двери?
									</p>
								</a>
							</div>
						</div>
						<div class="is-grid__item">
							<div class="b-grid-pattern__item">
								<a href="#" class="b-grid-pattern__i-img is-link" data-img="/img/tpl08.jpg"></a>
								<a href="#" class="b-grid-pattern__i-text is-link">
									<p>
										5 причин, по которым монтаж гаражных ворот лучше поручить профессионалам
									</p>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="is-section page-index__special-offer-sect wow" data-wow-offset="200">
		<div class="wrapper wrapper--sm">
			<a href="#" class="is-link">
				<div class="is-columns b-offer b-offer--type2">
					<div class="col b-offer__text-cont">
						<span class="b-label">Акция до 31 декабря</span>
						<div class="b-offer__text-block">
							<div class="b-offer__title">Акция на внутренние двери ZK</div>
							<p class="b-offer__text">Выгодное предложение на внутренние, сверхпрочные двери ZK для дома и административных помещений.</p>
						</div>
					</div>
					<div class="col b-offer__img">
                        <div class="b-offer__img__block" style="background-image:url(/img/tpl09.jpg)"></div>
						<span class="c-label">
							11 900 ₽
						</span>

					</div>

				</div>
			</a>
		</div>
	</section>

	<section class="is-section page-index__map-sect wow" data-wow-offset="200">
		<div class="wrapper wrapper--md">
			<div class="map-img" data-img="/img/map.png">
				<div class="b-center">
					<div class="h4">12 филиалов и более 600 <br> дилеров по всей России</div>
					<p class="is-text">
						Выгодное предложение на внутренние, сверхпрочные двери ZK для дома и административных помещений.
					</p>
					<a href="#" class="button button--md button--primary">
						<span class="button__text">Найти дилера</span>
					</a>
				</div>
			</div>
		</div>
	</section>

	<section class="is-section page-index__more-sect wow" data-wow-offset="200">
		<div class="page-slider page-slider--type-more" data-is="page-slider">
			<div class="wrapper-x-right-dir">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="page-slider__slide page-slider__slide--type3">
								<a href="#" class="item is-link" data-img="/img/tpl10.jpg" data-img-fast="1">
									<span class="page-slider__slide-ttl2">Медиа</span>
								</a>
								<a href="#" class="item is-link" data-img="/img/tpl11.jpg" data-img-fast="1">
									<span class="page-slider__slide-ttl2">Для дома</span>
								</a>
								<a href="#" class="item is-link" data-img="/img/tpl12.jpg" data-img-fast="1">
									<span class="page-slider__slide-ttl2">Для бизнеса</span>
								</a>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="page-slider__slide page-slider__slide--type4">
								<a href="#" class="item is-link">
									<span class="page-slider__slide-ttl2">Архитекторам</span>
								</a>
								<a href="#" class="item is-link">
									<span class="page-slider__slide-ttl2">Дилерам</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="wrapper wrapper--md">
				<div class="swiper-pagination js-pager"></div>
			</div>
		</div>
	</section>

</main>

<? include($_SERVER["DOCUMENT_ROOT"] . '/dist/include/footer.php'); ?>
