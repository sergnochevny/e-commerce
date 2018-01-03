(function ($) {
  'use strict';

  $(document).on('click', '#publish-comment', function (e) {
    e.preventDefault();

  }).on('click', 'a.public_comment', function (event) {
    event.preventDefault();
    var href = $(this).attr('href');
    var mode = "";
    var a1 = $(this).attr("value");

    $("#dialog-text").html((a1 == "1") ? "Hide comment?" : "Show comment?");

    $("#confirm_action").on('click.confirm_action',
      function (event) {
        event.preventDefault();
        $('#content').load(href);
        $("#confirm_dialog").removeClass('overlay_display');
        $('body').css('overflow', 'auto');
        $("#confirm_action").off('click.confirm_action');
      }
    );
    $("#confirm_dialog").addClass('overlay_display');
    $('body').css('overflow', 'hidden');
  });

  $(document).on('click.confirm_action', ".popup a.close", function (event) {
    event.preventDefault();
    $("#confirm_action").off('click.confirm_action');
    $("#confirm_dialog").removeClass('overlay_display');
    $('body').css('overflow', 'auto');
  }).on('click.confirm_action', "#confirm_no", function (event) {
    event.preventDefault();
    $(".popup a.close").trigger('click');
  }).on('click', 'a.del_user',
    function (event) {
      event.preventDefault();
      var href = $(this).attr('href');
      $("#dialog-text").html("You confirm the removal?");

      $("#confirm_action").on('click.confirm_action',
        function (event) {
          event.preventDefault();
          $('#content').load(href);
          $("#confirm_dialog").removeClass('overlay_display');
          $('body').css('overflow', 'auto');
          $("#confirm_action").off('click.confirm_action');
        }
      );

      $("#confirm_dialog").addClass('overlay_display');
      $('body').css('overflow', 'hidden');
    }
  ).on('click', 'a.view-comment',
    function (event) {
      event.preventDefault();
      var href = $(this).attr('href');

      $.get(href, function (data) {
        $("#comment-view-dialog-data").html(data);
      });

      $(".close").on('click.close', function (event) {
        event.preventDefault();
        $("#comment-view-dialog").removeClass('overlay_display');
        $('body').css('overflow', 'auto');
      });

      $("#comment-view-dialog").addClass('overlay_display');
      $('body').css('overflow', 'hidden');
    }
  ).on('click', 'a.edit-comment',
    function (event) {
      event.preventDefault();
      var href = $(this).attr('href'),
        href_update = $('#href_update_comment').val();

      $.get(href, function (data) {
        $("#comment-view-dialog-data").html(data);
        $("#add-form-send").bind("click", function () {
          $('#content').load(href_update);
        });
      });

      $(".close").on('click.close', function (event) {
        event.preventDefault();
        $('#content').load(href_update);
        $("#comment-view-dialog").removeClass('overlay_display');
      });
      $('body').css('overflow', 'hidden');
      $("#comment-view-dialog").addClass('overlay_display');
    }
  ).on('click', '.publ-comment', function () {
    var commentId = $(this).data('id');
    var commentAddress = $(this).data('address');
    var commentView = $(this).data('view-update');
    var commentTitle = $(this).data('title');
    var commentData = $(this).data('data');

    $.post(commentAddress, {
      id: commentId,
      comment_data: commentData,
      comment_title: commentTitle,
      publish: "1"
    }, function (data) {
//      console.log(data);
    }).get(commentView, "", function (data) {
//      console.log(data);
    });
  });


})(window.jQuery || window.$);
