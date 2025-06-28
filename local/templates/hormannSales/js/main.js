$(document).ready(function () {


    $('.series_tab').click(function () {
        $(this).closest('.series').find('.series_tab, .series_content').removeClass('active')
        $(this).addClass('active')
        $(this).closest('.series').find('.series_content').eq($(this).index()).addClass('active')
    })


    $('.menu_burger').click(function () {
        $('.header_inner, .menu_burger').toggleClass('active')
    })


    $('.menu > li').click(function (e) {
        if (!$(e.target).hasClass('dropdown_back')) {
            $(this).find('.dropdown').addClass('active')
        }

    })

    $(document).on('click', '.popup_btn', function () {
        event.preventDefault();
        const idPopup = $(this).attr('href'); -
            $.fancybox.close();
        $.fancybox.open({
            src: `#${idPopup}`,
            type: 'inline',
            touch: false,
            autoFocus: false,
        });
    });

    $('.dropdown_subtitle').click(function () {
        $(this).toggleClass('active')
        $(this).find('.dropdown_menu').slideToggle(400)
    })




    $('.header_search-open').click(function (e) {
        $('.header_search').toggleClass('active')
    })


    $('.kits_more').click(function (e) {
        e.preventDefault()
        $(this).remove()
        $('.kits_item').addClass('active')
    })

    $('.ways_item').click(function (e) {
        $('.ways_item').not(this).removeClass('active')
        $(this).addClass('active')
    })

    $('.dropdown_back').click(function () {
        if ($('.menu_mobile-links').hasClass('hide')) {
            $(this).closest('.dropdown ').find('.dropdown_item').removeClass('show')
            $(this).closest('.dropdown ').find('.menu_mobile-links').eq($(this).index()).removeClass('hide')
        }
        else {
            $(this).closest('.dropdown ').removeClass('active')
        }
    })

    $('.menu_mobile-link').click(function (e) {
        $(this).parent().addClass('hide')
        $(this).closest('.dropdown').find('.dropdown_item').eq($(this).index()).addClass('show')
    })

    $('.comparison_title').each(function () {
        $(this).css('top', $('.comparison_item-option').eq($(this).index()).position().top)
    })

    function padTo2Digits(num) {
        return num.toString().padStart(2, '0');
    }

    function formatDate(date) {
        return [
            padTo2Digits(date.getDate()),
            padTo2Digits(date.getMonth() + 1),
            date.getFullYear(),
        ].join('.');
    }

    var date = new Date();
    var lastDayDate = formatDate(new Date(date.getFullYear(), date.getMonth() + 1, 0));

    $('.sale_date').text(lastDayDate)

    $('.slider_ways').slick({
        slidesToShow: 3,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 767,
                settings: "unslick",
            },
        ]
    })


    $('input[type=tel]').mask('+7 (999) 999-99-99');



    $(window).on('resize', function () {
        if ($(window).width() > '767') {
            $('.slider_ways').slick('refresh');
        }
    });

    $(window).scroll(function () {
        if ($(window).scrollTop() > 300) {
            $('.header').addClass('fixed')
            $('.scroll').addClass('fixed')
        }
        else {
            $('.header').removeClass('fixed')
            $('.scroll').removeClass('fixed')
        }



        if (window.pageYOffset > 100 && window.pageYOffset > window.scrolltop) {
            $('.header').addClass('up');
        }
        else {
            $('.header').removeClass('up');
        }
        scrolltop = pageYOffset;


        $('.series_item.fixed').each(function () {
            const scrollTop = $(window).scrollTop();
            const cardPossition2 = $(this).offset().top - 86;
            const cardWrapperHeight2 = $(this).height();
            const cardLeftHeight2 = $(this).find('.series_item-img').height();

            if (scrollTop < cardPossition2) {
                $(this).find('.series_item-img').css('top', '0px');
            }
            else {
                if (scrollTop > cardPossition2 && scrollTop < cardPossition2 + cardWrapperHeight2 - cardLeftHeight2) {
                    $(this).find('.series_item-img').css('top', scrollTop - cardPossition2 + 'px');
                } else {
                    $(this).find('.series_item-img').css('top', cardWrapperHeight2 - cardLeftHeight2 + 'px');
                }
            };
        })
    })


    $('.works_slider').slick({
        slidesToShow: 4,
        responsive: [
            {
                breakpoint: 1250,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 767,
                settings: "unslick",
            },
        ]
    })

    $('.doors_slider').slick({
        variableWidth: true,
        // infinite: false,
        responsive: [
            {
                breakpoint: 767,
                settings: "unslick",
            },
        ]
    })
    $('.doors_slider-duo').slick({
        variableWidth: true,

        responsive: [
            {
                breakpoint: 767,
                settings: "unslick",
            },
        ]
    })







})