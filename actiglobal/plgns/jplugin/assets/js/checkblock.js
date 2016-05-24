!function($) {

    $('.wp-tab-panel.vc_checkblock').each(function(){
        var parent = this;
        var input = $(parent).find('.wpb-input');

        $(this).find('.checkblock').bind('click', function(){
            var result = [];
            $(parent).find('.checkblock').each(function(){
                if($(this).is(":checked")) {
                    result.push($(this).val());
                }
            });
            $(input).val(result);
        });
    });
}(window.jQuery);