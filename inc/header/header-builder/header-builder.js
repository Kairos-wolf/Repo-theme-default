jQuery(document).ready(function ($) {
    function updateHiddenInput() {
        let newOrder = [];
        $('#ht-header-sortable .ht-sortable-item').each(function () {
            newOrder.push($(this).data('item'));
        });
        $('#customize-control-ht_header_layout input[type="hidden"]').val(JSON.stringify(newOrder)).trigger('change');
    }

    $("#ht-header-sortable, #ht-header-available").sortable({
        connectWith: ".ht-sortable",
        update: function (event, ui) {
            updateHiddenInput();
        }
    }).disableSelection();
});
