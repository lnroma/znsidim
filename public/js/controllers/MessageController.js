var myApp = angular.module('myApp');
myApp.controller('MessageController', function ($scope, $compile) {
    $scope.render = function (id_editor) {
        // var html = eval($scope.textContent_+id_editor);
        var html = $('#'+id_editor).val();
        if (html == undefined) {
            return '';
        }
        for (var smile in $scope.smiles) {
            html = html.replaceAll(smile, '<img src="' + $scope.smiles[smile] + '" />');
        }
        return html;
    };

    $scope.remove = function (id_editor) {
        $('#file_upload_' + id_editor).val('');
    };

    $scope.submitForm = function (form_id) {
        $('#'+form_id).submit();
    };

    $scope.choose_file = function (id_editor) {
        $.ajax({
            url: '/file/get_uploaded?id_editor=' + id_editor,
            dataType: 'json',
            type: 'get',
            success: function (result) {
                if(result.html) {
                    var element = $('#file_table_' + id_editor).html(result.html);
                    $compile(element)($scope);
                }
            }
        });
    };

    $scope.send = function (url, id_editor) {
        $scope.insertSmile('<a href="'+url+'"><img src="'+url+'" height="200px"></a>', id_editor);
    };

    $scope.upload = function (id_editor) {
        var file = $('#file_upload_' + id_editor).prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file);
        form_data.append('id_editor', id_editor);
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
                $scope.insertSmile('<a href="'+result.url+'"><img src="'+result.url+'" height="200px"></a>', result.id_editor);
                $scope.$digest();
                $('#file_upload_' + id_editor).val('');
            }
        });
    };

    $scope.bold = function (id_editor) {
        $scope.inputTags('<b>', '</b>', null, id_editor);
        angular.element(jQuery('#' + id_editor)).triggerHandler('input');
    };

    $scope.italic = function (id_editor) {
        $scope.inputTags('<i>', '</i>', null, id_editor);
        angular.element(jQuery('#' + id_editor)).triggerHandler('input');
    };

    $scope.strice = function (id_editor) {
        $scope.inputTags('<strike>', '</strike>', null, id_editor);
        angular.element(jQuery('#' + id_editor)).triggerHandler('input');
    };

    $scope.insertSmile = function (smile, id_editor) {
        console.log(id_editor);
        var allMessage = $('#' + id_editor).val();
        var positionStart = $('#' + id_editor).prop('selectionStart');

        var startString = allMessage.substring(0, positionStart);
        var endString = allMessage.substring(positionStart, allMessage.length);

        $('#' + id_editor).val(startString + smile + endString);

        angular.element(jQuery('#' + id_editor)).triggerHandler('input');
    };

    $scope.inputTags = function (tag1, tag2, text, id_editor) {

        var allMessage = $('#' + id_editor).val();
        var positionStart = $('#' + id_editor).prop('selectionStart');
        var positionEnd = $('#' + id_editor).prop('selectionEnd');

        var startString = allMessage.substring(0, positionStart);
        var midleString = allMessage.substring(positionStart, positionEnd);
        var endString = allMessage.substring(positionEnd, allMessage.length);

        if(text != undefined) {
            $('#' + id_editor).val(startString + tag1 + text + tag2 + endString);
        } else {
            $('#' + id_editor).val(startString + tag1 + midleString + tag2 + endString);
        }
        angular.element(jQuery('#' + id_editor)).triggerHandler('input');
    }
});

myApp.filter('unsafe', function ($sce) {
    return $sce.trustAsHtml;
});

String.prototype.replaceAll = function (search, replace) {
    return this.split(search).join(replace);
};
