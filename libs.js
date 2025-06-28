'use strict';
/**
 * Содержит пути к библиотекам, установленных с помощью Yarn и компилирующихся в vendor.min.(css|js)
 */
module.exports = {
    styles: [
    	'node_modules/swiper/dist/css/swiper.min.css',
    ],
    scripts: [
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/swiper/dist/js/swiper.min.js',
        'node_modules/wow.js/dist/wow.js',
        'sources/js/vendors/jquery.inview.min.js',
        'sources/js/vendors/masked.input.js',
    ]
}