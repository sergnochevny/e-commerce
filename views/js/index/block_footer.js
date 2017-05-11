'use strict';

(function ($) {
  $(document).ready(function (event) {
    if ($('#bsells_products').length && $('#hidden_bsells_products').length) $('#bsells_products').load($('#hidden_bsells_products').val());
    if ($('#popular_products').length && $('#hidden_popular_products').length) $('#popular_products').load($('#hidden_popular_products').val());
    if ($('#new_products').length && $('#hidden_new_products').length) $('#new_products').load($('#hidden_new_products').val());
    if ($('#best_products').length && $('#hidden_best_products').length) $('#best_products').load($('#hidden_best_products').val());
    }
  );
})(jQuery);
