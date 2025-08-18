jQuery(document).ready(function ($) {
    function updateFooterHiddenInput() {
        let newOrder = [];

        $('#ht-footer-sortable .ht-footer-sortable-item').each(function () {
            newOrder.push($(this).data('item'));
        });

        $('#customize-control-ht_footer_layout input[type="hidden"]')
            .val(JSON.stringify(newOrder))
            .trigger('change');
    }

    $("#ht-footer-sortable, #ht-footer-available").sortable({
        connectWith: ".ht-footer-sortable",
        update: function (event, ui) {
            updateFooterHiddenInput();
        }
    }).disableSelection();

});
