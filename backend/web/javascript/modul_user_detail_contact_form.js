$('#moduluserdetailcontact-type').change(function () {
    var companyField = $('.field-moduluserdetailcontact-company');
    if(this.value != TYPE_PROVIDER)
    {
        companyField.fadeOut();
        companyField.find('input').prop('disabled', true);
    }
    else
    {
        companyField.fadeIn();
        companyField.find('input').prop('disabled', false);
    }
    var receiveAdminMailField = $('.field-moduluserdetailcontact-receive-admin-mail-field');
    if(this.value == TYPE_PROVIDER)
    {
        receiveAdminMailField.fadeOut();
        receiveAdminMailField.find('input').prop('disabled', false);
    }
    else
    {
        receiveAdminMailField.fadeIn();
        receiveAdminMailField.find('input').prop('disabled', true);
    }
});
