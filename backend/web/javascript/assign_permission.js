function permSelected() {
    "use strict";
    var key = $("#assignmentlist").val(); // The value of the selected option
    $('.permissionField').fadeOut(); // disable enabled fields

    $.ajax({
        // var hostUrl is expected to be registered before registering this JS file
        // and thus is globally available
        url: hostUrl + '/user-stamm/assign-ajax',
        type: 'POST',
        data: {permission: key},
        success: function (resp) {
            // resp is a JSON object
            var data = JSON.parse(resp);
            // the form field with ids in the array will be displayed and its label modified
            $('#usertext').fadeIn();
            $('#usertext' + ' > div > div > label').text(data[0]);
        }
    })
}