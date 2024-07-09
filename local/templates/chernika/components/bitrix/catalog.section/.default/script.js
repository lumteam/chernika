if (typeof (jQuery) != 'undefined' && jQuery().axpajax) {
    $(document).ready(function () {
        $('#js-ax-ajax-pagination-content-container').axpajax({
            lazyDynamic: false,
            lazyDynamicTimeout: 0,
            lazyDynamicOffset: -300,
            lazyDynamicDelayedStart: false,
            pagination: '.js-ax-ajax-pagination-container a.js-ax-pager-link',
            lazyLoad: '.js-ax-ajax-pagination-container .js-ax-show-more-pagination',
            lazyContainer: '.js-ax-ajax-pagination-container',
            specialParams: {
                ajax_page: true
            },
            callbacks: {
                beforeLoad: function (obj) {
                    $('#chernika-preloader').addClass('show');
                },
                afterLoad: function (obj) {
                    $('#chernika-preloader').removeClass('show');
                },
                onError: function (err) {
                }
            }
        });
    });
}