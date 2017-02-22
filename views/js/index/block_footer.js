'use strict';

(function ($) {
  $(document).ready(function (event) {
      $('#bsells_products').load($('#hidden_bsells_products').val());
      $('#popular_products').load($('#hidden_popular_products').val());
      $('#new_products').load($('#hidden_new_products').val());
      $('#best_products').load($('#hidden_best_products').val());
    }
  );
})(jQuery);
