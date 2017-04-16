/**
 * Chatra plugin for Craft CMS
 *
 * Chatra JS
 *
 * @author    Superbig
 * @copyright Copyright (c) 2016 Superbig
 * @link      https://superbig.co
 * @package   Chatra
 * @since     1.0.0
 */
var $chatraForm = $('#js-chatraMessageForm');

if ($chatraForm.length) {
    var $chatraSuccess = $('#js-chatraSuccess');
    var $chatraMessage = $('#js-chatraMessage');

    $chatraForm.on('submit', function(event) {
        event.preventDefault();

        var data = $chatraForm.serialize();
        console.log(data);

        Craft.postActionRequest(data.action, data, function(response) {
            if (response.success) {
                $chatraSuccess.addClass('is-visible');
                $chatraMessage.val('');

                setTimeout(function() {
                    $chatraSuccess.removeClass('is-visible');
                }, 3000);
            }
        })
    });
}