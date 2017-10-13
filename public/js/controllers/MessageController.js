var myApp = angular.module('myApp');
myApp.controller('MessageController', function ($scope) {
    $scope.render = function (content) {
        var html = $scope.textContent;
        if (html == undefined) {
            return '';
        }
        for (var smile in $scope.smiles) {
            html = html.replaceAll(smile, '<img src="' + $scope.smiles[smile] + '" />');
        }
        content = html;
        return content;
    };

    $scope.remove = function () {
        $('#file_upload').val('');
    };

    $scope.upload = function () {
        var file = $('#file_upload').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file);
        var url = null;
        $.ajax({
            url: '/file/upload',
            dataType: 'json',
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            success: function (result) {
                $scope.picture = result.url;
                $scope.show_preview = true;
                $scope.insertSmile('<a href="'+result.url+'"><img src="'+result.url+'" height="200px"></a>');
                $scope.$digest();
                $('#file_upload').val('');
            }
        });
    };

    $scope.bold = function () {
        $scope.inputTags('<b>', '</b>');
    };

    $scope.italic = function () {
        $scope.inputTags('<i>', '</i>');
    };

    $scope.strice = function () {
        $scope.inputTags('<strike>', '</strike>')
    };

    $scope.insertSmile = function (smile) {
        var allMessage = $('#message').val();
        var positionStart = $('#message').prop('selectionStart');

        var startString = allMessage.substring(0, positionStart);
        var endString = allMessage.substring(positionStart, allMessage.length);

        $('#message').val(startString + smile + endString);
    };

    $scope.inputTags = function (tag1, tag2, text) {

        var allMessage = $('#message').val();
        var positionStart = $('#message').prop('selectionStart');
        var positionEnd = $('#message').prop('selectionEnd');

        var startString = allMessage.substring(0, positionStart);
        var midleString = allMessage.substring(positionStart, positionEnd);
        var endString = allMessage.substring(positionEnd, allMessage.length);

        if(text != undefined) {
            $('#message').val(startString + tag1 + text + tag2 + endString);
        } else {
            $('#message').val(startString + tag1 + midleString + tag2 + endString);
        }
    }
});
myApp.filter('unsafe', function ($sce) {
    return $sce.trustAsHtml;
});
String.prototype.replaceAll = function (search, replace) {
    return this.split(search).join(replace);
};
