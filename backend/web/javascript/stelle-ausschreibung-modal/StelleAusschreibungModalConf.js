$(document).ready(function(){
    var dialogDiv = $('#ausschreibung_dialog');
    var viewButtons = $('.viewModalButton');
    dialogDiv.dialog({
        title: 'Hinweis',
        modal: true,
        autoOpen: false,
        width: 550,
        resizable: false,
        buttons: [
            {
                html: 'Schlie&szlig;en',
                click: function () {
                    jQuery(this).dialog('close');
                },
            }
        ]
    });

    $('.viewModalButton').click(function(e){
        e.preventDefault();
        if(jQuery(this).hasClass('suspended'))
        {
            return false;
        }
        var id = $(this).data('id');
        viewButtons.addClass('suspended');
        $.ajax({
            url: ajaxUrl + id,
            type: 'POST',
            dataType: 'html',
            success: function (result) {
                dialogDiv.find('#ausschreibungs-modal-content').html(result);
                dialogDiv.dialog('open');
            }
        }).done(function () {
            viewButtons.removeClass('suspended');
        });
    });
});