'use strict';

function publishComment(address, view_update){
    var title = jQuery("#comment_title").text(),
        data = jQuery("#comment_data").text();

    jQuery.post(address, {comment_data : data, comment_title : title, publish : "1"}, function(data){
        console.log(data);
    }).get(view_update, "", function(data){
        console.log(data);
    });
}