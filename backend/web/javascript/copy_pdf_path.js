$('.copy-icon').click(function () {
    var jQthis = $(this);
    var copyLinkInput = document.getElementById('link' + jQthis.data('id'));
    $.ajax({
        url: jQthis.data('url'),
        type: 'POST',
        data: {offerPath: jQthis.data('offerPath')},
        async: false,
        success: function (link) {
            copyLinkInput.value = link;
            jQthis.data('offerPath');
        }
    });
    copyLinkInput.type = 'text';
    copyLinkInput.select();
    document.execCommand('copy');
    copyLinkInput.type = 'hidden';
});