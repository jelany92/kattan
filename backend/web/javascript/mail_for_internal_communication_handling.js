$("#userstammform-company").on("change input paste",function(){
    $("#userstammform-emailforinternalcommunication").val(convertToMail($(this).val()));
});

/**
 * Replaces assorted characters with mail-friendly equivalents
 *
 * @param companyName
 * @returns {string}
 */
function convertToMail(companyName)
{
    companyName = companyName.toLowerCase();
    companyName = companyName.replace(/ä/g, 'ae');
    companyName = companyName.replace(/ö/g, 'oe');
    companyName = companyName.replace(/ü/g, 'ue');
    companyName = companyName.replace(/ß/g, 'ss');
    companyName = companyName.replace(/ /g, '-');
    companyName = companyName.replace(/\./g, '');
    companyName = companyName.replace(/,/g, '');
    companyName = companyName.replace(/\(/g, '');
    companyName = companyName.replace(/\)/g, '');
    companyName = companyName.replace(/\@/g, '');
    companyName = companyName.replace(/\\/g, '');
    companyName = companyName.replace(/\//g, '');
    return companyName;
}