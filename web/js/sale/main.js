const printCoupon = () => {
    window.onbeforeprint = () => {
        $('body').addClass('print-coupon');
        $('.coupon').removeClass('d-none');
        $('[media=all]').prop('media', 'screen');
    };

    window.onafterprint = () => {
        window.onbeforeprint = window.onafterprint = null;

        $('[media=screen]').prop('media', 'all');
        $('body').removeClass('print-coupon');
        $('.coupon').addClass('d-none');
    };

    window.print();
};