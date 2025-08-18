jQuery(document).ready(function ($) {
    function updateTopbarHiddenInput() {
        let newOrder = [];

        $('#ht-topbar-sortable .ht-topbar-sortable-item').each(function () {
            newOrder.push($(this).data('item'));
        });

        $('#customize-control-ht_topbar_layout input[type="hidden"]')
            .val(JSON.stringify(newOrder))
            .trigger('change');
    }

    $("#ht-topbar-sortable, #ht-topbar-available").sortable({
        connectWith: ".ht-topbar-sortable",
        update: function (event, ui) {
            updateTopbarHiddenInput();
        }
    }).disableSelection();

});
