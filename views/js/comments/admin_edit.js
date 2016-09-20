'use strict';
function sendComment(address, id){
    var title = jQuery("#comment_title").attr("value"),
        data = jQuery("#comment_data").attr("value"),
        messageBlock = jQuery("#comment-message-error"),
        commentPublic = jQuery("#comment_public"),
        pub = commentPublic.attr("checked");

    pub = (pub != 'checked') ? 0 : 1;

    jQuery.post(address, {comment_data : data, comment_title : title, ID : id, publish : pub}, function(data){
        if(data.length > 0){
            messageBlock.html(data);
            if(messageBlock.attr('display') != 'none') {
                messageBlock.stop().slideDown(400);
            }
            messageBlock.delay(5000).stop().slideUp(400);
        }
    });
}