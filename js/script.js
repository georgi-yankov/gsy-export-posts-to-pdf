(function($) {
    'use strict';

    $(document).ready(function() {
        var gsyExportPostsToPdf,
                exportToPdfBtn;

        gsyExportPostsToPdf = $('#gsy-export-posts-to-pdf');
        exportToPdfBtn = $('#submit', gsyExportPostsToPdf);

        // Attach events
        $('input[type=checkbox]', gsyExportPostsToPdf).click(existCheckedCheckbox);

        function existCheckedCheckbox() {
            var existChecked;

            existChecked = false;

            $('input[type=checkbox]', gsyExportPostsToPdf).each(function() {
                if (this.checked === true) {
                    existChecked = true;
                    return false;
                }
            });

            if (existChecked) {
                exportToPdfBtn.removeAttr('disabled');
            } else {
                exportToPdfBtn.attr('disabled', 'disabled');
            }
        }

    });

})(jQuery);