// антри-спам для комментов
$(document).ready(function() {
    commentForm = $('form[action="/blogs/comment"');
    if ($(commentForm).length > 0) {
        $(commentForm).append('<input type="hidden" name="antispam" value="true">');
    }
});