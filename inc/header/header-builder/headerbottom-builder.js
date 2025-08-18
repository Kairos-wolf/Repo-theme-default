jQuery(document).ready(function ($) {
    function updateHeaderBottomHiddenInput() {
        let newOrder = [];

        $('#ht-headerbottom-sortable .ht-headerbottom-sortable-item').each(function () {
            newOrder.push($(this).data('item'));
        });

        $('#customize-control-ht_headerbottom_layout input[type="hidden"]')
            .val(JSON.stringify(newOrder))
            .trigger('change');
    }

    $("#ht-headerbottom-sortable, #ht-headerbottom-available").sortable({
        connectWith: ".ht-headerbottom-sortable",
        update: function (event, ui) {
            updateHeaderBottomHiddenInput();
        }
    }).disableSelection();

});
