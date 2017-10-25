'use strict';
(function($) {
  $.widget('gregpopov.charCounter', {
    options: {
      charsLimit: null,
      charsLimitOutputBlock: null,
      outputNotificationBlock: null
    },
    _create: function() {
      if (this.element.val() < 1) {
        $(this.options.charsLimitOutputBlock).text(this.options.charsLimit);
        $(this.options.outputNotificationBlock).text(' characters left');
      }
      this.element.attr('maxlength', this.options.charsLimit);
      this._on(this.element, {
        keyup: "_countCharacters"
      });
    },
    _countCharacters: function() {
      var counterMessage, textLength;
      textLength = this.element.val().length;
      counterMessage = '';
      if (textLength < this.options.charsLimit) {
        $(this.options.charsLimitOutputBlock).text(this.options.charsLimit - textLength);
        counterMessage = this._pluralOrSingle(textLength);
        $(this.options.outputNotificationBlock).text(counterMessage);
      } else {
        counterMessage = 'You have reached the character limit';
        $(this.options.charsLimitOutputBlock).text('');
        $(this.options.outputNotificationBlock).text(counterMessage);
      }
    },
    _pluralOrSingle: function(number) {
      var message;
      message = ' characters left';
      if ((this.options.charsLimit - number) === 1) {
        message = ' character left';
      }
      return message;
    }
  });
})(jQuery);
