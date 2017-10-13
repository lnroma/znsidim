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

$('.radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);

    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});