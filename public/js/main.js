// антри-спам для комментов
$(document).ready(function() {
    commentForm = $('form[action="/blogs/comment"');
    if ($(commentForm).length > 0) {
        $(commentForm).append('<input type="hidden" name="antispam" value="true">');
    }

    commentPhotoForm = $('form[action="/photo/comment"');
    if ($(commentPhotoForm).length > 0) {
        $(commentPhotoForm).append('<input type="hidden" name="antispam" value="true">');
    }

    $(".spoiler-trigger").click(function() {
        $(this).parent().next().collapse('toggle');
    });
});