'use strict';

(function($){

    $('#dateTo').datepicker({
        dateFormat: 'mm/dd/yy',
        onSelect: function (dateText, inst) {
            $('#dateFrom').datepicker('option', 'maxDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
        }
    });

    $('form#discount').on('submit',
        function (event) {
//            event.preventDefault();
//            var msg = $(this).serialize();
//            var url = $(this).attr('action');
            $('body').waitloader('show');
//            $.ajax({
//                type: 'POST',
//                url: url,
//                data: msg,
//                success: function (data) {
//                    $('#discount_form').html(data);
//                    $('.danger').css('display', 'block');
//                    $('body').waitloader('remove');
//                    $('html, body').animate({scrollTop: parseInt($('.danger').offset().top) - 250 }, 1000);
//                    setTimeout(function () {
//                        $('.danger').css('display', 'none');
//                    }, 8000);
//                },
//                error: function (xhr, str) {
//                    alert('Error: ' + xhr.responseCode);
//                }
//            });
        }
    );

    $(document).ready(
        function(){
            $('content').waitloader('remove');
            if ($('.danger').length > 0){
                $('.danger').css('display', 'block');
                $('html, body').stop().animate({scrollTop: parseInt($('.danger').offset().top) - 250 }, 1000);
                setTimeout(function () {
                    $('.danger').css('display', 'none');
                }, 8000);
            }
        }
    );

})(jQuery);

function toggleDiscountType(enable){
    var dtlSlct = document.getElementById('iDscntType');
    var mlt = document.getElementById('allow_multiple');
    var fbtAll = document.getElementById('sel_fabrics1');
    var l_ship = document.getElementById('l_ship');
    var f_ship = document.getElementById('f_ship');

    if(dtlSlct.selectedIndex == 2){

        mlt.checked = true;
        fbtAll.checked = true;
        l_ship.style.display = '';
        f_ship.style.display = '';

        toggleFabrics();
    } else {
        l_ship.style.display = 'none';
        f_ship.style.display = 'none';
    }

    toggleDetailSelect(dtlSlct, false);

}

function toggleCouponCode(enable) {
    var txtCoupon = document.getElementById('coupon_code');
    var chckCoupon = document.getElementById('generate_code');
    var chckMlt = document.getElementById('allow_multiple');
    var fbtAll = document.getElementById('sel_fabrics1');
    var fbtSlct = document.getElementById('sel_fabrics2');

    //if the coupon code is entered or the generate the coupon code box is checked then we have to make the multiple box checked
    //this is because we are enforcing the system to make is so that all promotions with a coupon code are added to other deals
    //we also can not be doing the
    if ((txtCoupon.value.length > 0) || (chckCoupon.checked)) {
        chckMlt.checked = true;
        fbtAll.checked = true;

        toggleFabrics();
    }

}

function toggleDetailSelect(dtlSlct, disable){
    dtlSlct.disabled = disable;
}

function toggleFabrics(){
    var fl = document.getElementById('fabric_list');
    var sf1 = document.getElementById('sel_fabrics1');

    fl.disabled = sf1.checked;
}

function toggleDetails() {
    var fbtAll = document.getElementById('sel_fabrics1');
    var fbtSlct = document.getElementById('sel_fabrics2');
    var dtlSlct = document.getElementById('iDscntType');

    toggleFabrics();

    if (fbtSlct.checked) {
        dtlSlct.selectedIndex = 1;
    }

    toggleDiscountType(true);

}

function toggleUsers() {
    var ul = document.getElementById('users_list');
    var uc4= document.getElementById('users_check4');
    ul.disabled = !uc4.checked;
}

//    toggleDetails();
//    toggleDiscountType(false);
//    toggleCouponCode(false);

var fl = document.getElementById('fabric_list');
var sf1 = document.getElementById('sel_fabrics1');
var ul = document.getElementById('users_list');
var uc4= document.getElementById('users_check4');

fl.disabled = sf1.checked;
ul.disabled = !uc4.checked;
