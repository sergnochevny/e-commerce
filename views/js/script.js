jQuery(document).ready(function($){
	'use strict';

	/* Keyboard image navigation */
	if ( $('body').hasClass('attachment-jpg') || 
		$('body').hasClass('attachment-jpeg') || 
		$('body').hasClass('attachment-jpe') || 
		$('body').hasClass('attachment-gif') || 
		$('body').hasClass('attachment-png') 
	) {
		$( document ).keydown( function( e ) {
			var url = false;
			if ( e.which === 37 ) {  // Left arrow key code
				url = $( '.image-navigation .nav-previous a' ).attr( 'href' );
			}
			else if ( e.which === 39 ) {  // Right arrow key code
				url = $( '.image-navigation .nav-next a' ).attr( 'href' );
			}
			if ( url && ( !$( 'textarea, input' ).is( ':focus' ) ) ) {
				window.location = url;
			}
		} );
	}
	
	/* Style Comments */
	$('#commentsubmit').addClass('btn btn-primary');

	/* Style WordPress Default Widgets */
	$('.widget select').addClass('form-control');
	$('.widget table#wp-calendar').addClass( 'table table-bordered').unwrap().find('th, td').addClass('text-center');
	$('.widget-title .rsswidget img').hide();
	$('.widget-title .rsswidget:first-child').append('<i class="fa fa-rss pull-right">');

	/* Move cross-sell below cart totals on cart page */
	$('.woocommerce .cart-collaterals .cross-sells, .woocommerce-page .cart-collaterals .cross-sells').appendTo('.woocommerce .cart-collaterals, .woocommerce-page .cart-collaterals');
});

(
	function($){
		$.fn.extend({
			waitloader: function (action) {
				var wait_loader_fa = '<div class="ui-widget-overlay" id="wait_loader">' +
					'<i class="fa fa-spinner fa-pulse fa-4x"></i>' +
					'</div>';
				switch (action) {
					case 'show':
						if ($('#wait_loader').length == 0) {
							$(wait_loader_fa).appendTo(this).css('z-index', '100000000');
						}
						break;
					case 'remove':
						if ($('#wait_loader').length > 0) {
							$('#wait_loader').remove();
						}
						break;
				}
			}
		});

		$(document).on('click', '#b_search',
			function(event){
				$('#f_search').trigger('submit');
			}
		);

		$(function () {
			//$("a.zoom").prettyPhoto({
			//	hook: "data-rel",
			//	social_tools: !1,
			//	theme: "pp_woocommerce",
			//	horizontal_padding: 20,
			//	opacity: .8,
			//	deeplinking: !1
			//});

			$("a[data-rel^='prettyPhoto']").prettyPhoto({
				hook: "data-rel",
				social_tools: '',
				theme: "pp_woocommerce",
			//	horizontal_padding: 20,
			//	opacity: .8,
			//	show_title: false,
			//  allow_resize: true,
				allow_expand: true,
			 	default_width: 700
			});
		});
	}
)(jQuery);




