function linkReplace() {
    $('span.linkReplace').each(function() {
        var linkHref = $(this).data('href');
        var linkClass = $(this).attr('class');
        var linkExternal = $(this).data('ext');
        var linkText = $(this).html();
        var linkBlank = '';
        if(linkExternal == "Y") linkBlank = 'target="_blank"';

        $(this).after('<a href="'+linkHref+'" '+linkBlank+' class="'+linkClass+'">'+linkText+'</a>').remove();
    });
}

$(document).ready(function() {
    linkReplace();
});

$(document).ajaxComplete(function(event, request, settings) {
    linkReplace();
});