'use strict';

function sendComment(address) {
    var title = jQuery("#comment_title").attr("value"),
        data = jQuery("#comment_data").attr("value");

    jQuery.post( address, {
      comment_data: data,
      comment_title: title
    }, function (data) {
      if (data.length > 0) {
            jQuery("#comment-message-error").html(data);
        if (jQuery("#comment-message-error-success").length > 0) {
                jQuery("#comment-form-head").stop().hide(400);
                jQuery("#comment-form-data").stop().hide(400);
                jQuery("#comment-form-save").stop().hide(400);
            }
        }
    });
}
