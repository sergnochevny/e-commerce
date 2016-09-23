'use strict';
(function ($) {

    $('content').waitloader('remove');

    if ($('.danger').length) {
        $('.danger').show();
        $('html, body').animate({scrollTop: parseInt($('.danger').offset().top) - 250}, 1000);
        setTimeout(function () {
            $('.danger').hide();
        }, 8000);
    }

    $('#dateFrom').datepicker({
        dateFormat: 'mm/dd/yy',
        onSelect: function (dateText, inst) {
            $('#dateTo').datepicker('option', 'minDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
        }
    });

    $('#dateTo').datepicker({
        dateFormat: 'mm/dd/yy',
        onSelect: function (dateText, inst) {
            $('#dateFrom').datepicker('option', 'maxDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
        }
    });

    function postdata(this_, url, data, context, callback) {
        $('body').waitloader('show');
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {
                $.when(context.html(data)).done(
                    function(){
                        if(callback) callback.apply(this_);
                        $('body').waitloader('remove');
                    }
                );
            },
            error: function (xhr, str) {
                alert('Error: ' + xhr.responseCode);
                $('body').waitloader('remove');
            },
        });
    }

    $('form#discount').on('submit',
        function (event) {
            event.preventDefault();
            var data = new FormData(this);
            var url = $(this).attr('action');
            postdata(this, url, data, $('#discount_form'));
        }
    );

    function evFilterAdd(event) {
        var data = new FormData($('form#discount')[0]);
        var url = $('form#discount').attr('action');
        data.append('method', $(this).attr('href'));
        var destination = $(this).attr('data-destination');
        var title =  $(this).attr('data-title');
        postdata(this, url, data, $('#modal_content'),
            function(){
                $('#modal-title').html(title);
                $('#build_filter').attr('data-destination', destination);
                $('#modal').modal('show');
            }
        );
    }

    $('#build_filter').on('click',
        function(){
            var destination = $('[data-filter='+$(this).attr('data-destination')+']').parent('div');
            var data = new FormData($('form#discount')[0]);
            var url = $('form#discount').attr('action');
            data.append('method', $(this).attr('href'));
            data.append('type', $(this).attr('data-destination'));
            postdata(this, url, data, destination,
                function(){
                    $('#modal').modal('hide');
                    $('span[data-rem_row]').on('click',
                        function (event) {
                            evRemoveFilterRow.apply(this, event);
                        }
                    );
                    $('form#discount a[name=edit_filter]').on('click',
                        function(event){
                            event.preventDefault();
                            evFilterAdd.apply(this, event);
                        }
                    );
                }
            );
        }
    );


    $('form#discount a[name=edit_filter]').on('click',
        function(event){
            event.preventDefault();
            evFilterAdd.apply(this, event);
        }
    );

    function evRemoveFilterRow(event) {
        $(this).parent('li.prod_sel_category_item').remove();
    }

    $('span[data-rem_row]').on('click',
        function (event) {
            event.preventDefault();
            evRemoveFilterRow.apply(this, event);
        }
    );

    $('#modal').on('hidden.bs.modal',
        function(){
            $(this).find('#modal_content').empty();
        }
    );

})
(jQuery);

function toggleDiscountType(enable) {
    var dtlSlct = document.getElementById('iDscntType');
    var mlt = document.getElementById('allow_multiple');
    var fbtAll = document.getElementById('sel_fabrics1');
    var l_ship = document.getElementById('l_ship');
    var f_ship = document.getElementById('f_ship');

    if (dtlSlct.selectedIndex == 2) {

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

function toggleDetailSelect(dtlSlct, disable) {
    dtlSlct.disabled = disable;
}

function toggleFabrics() {
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
    var ul = document.getElementById('users');
    var uc4 = document.getElementById('users_check4');
    ul.disabled = !uc4.checked;
}
