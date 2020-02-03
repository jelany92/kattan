$('.copy-button').click(function () {
    var jQthis = $(this);
    var copyLinkInput = document.getElementById('link' + jQthis.data('id'));
    $.ajax({
        url: jQthis.data('url'),
        type: 'POST',
        data: {id: jQthis.data('id'), evaluator: jQthis.data('evaluator'), createNewToken: jQthis.data('createNewToken')},
        async: false,
        success: function (link) {
            copyLinkInput.value = link;
            jQthis.data('createNewToken', 0);
        }
    });
    copyLinkInput.type = 'text';
    copyLinkInput.select();
    document.execCommand('copy');
    copyLinkInput.type = 'hidden';

});