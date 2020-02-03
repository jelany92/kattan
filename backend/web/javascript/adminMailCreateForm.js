$('[name="AdminMailForm[service]"]').change(function () {
    var value = $(this).val();
    $('.conditional-field').hide();
    if (value <= 2) {
        elementToShow = $('.customer-field');
    } else {
        elementToShow = $('.permission-field');
    }
    elementToShow.find('.select2-search__field').css('width', '100%');
    elementToShow.show();
})
;

$('#document').ready(function () {
    if ($('#choose-radio-list').val() <= 2) {
        elementToShow = $('.customer-field').show();
    } else {
        elementToShow = $('.permission-field').show();
    }
});

$('#type-list-1').click(function () {
    elementToShow = $('.template-field');
    if ($(this).prop('checked')) {
        elementToShow.show();
    } else {
        elementToShow.hide();
    }
    elementToShow.find('.select2-search__field').css('width', '100%');
});
$('#document').ready(function () {
    if ($('#type-list-1').attr('checked')) {
        elementToShow = $('.template-field').show();
    }
    ;

    $('#signature-dropdown').change(function () {
       var option = $(this).find('option:selected');
       if(option.data('html') !== undefined)
       {
           tinyMCE.get('signature_editor').setContent(option.data('html'));
       }
    });
});
