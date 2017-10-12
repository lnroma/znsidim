var myApp=angular.module('myApp');
myApp.controller('MessageController',  function($scope) {
    $scope.render = function (content) {
        var html = $scope.textContent;
        if(html == undefined) {
            return '';
        }
        console.log($scope.smiles);
        for (var smile in $scope.smiles) {
            html = html.replaceAll(smile, '<img src="' + $scope.smiles[smile] + '" />');
        }
        html = html.replaceAll('[b]', '<b>');
        html = html.replaceAll('[/b]', '</b>');
        html = html.replaceAll('[s]', '<strike>');
        html = html.replaceAll('[/s]', '</strike>');
        html = html.replaceAll('[i]', '<i>');
        html = html.replaceAll('[/i]', '</i>');

        html = html.replaceAll('[quote]', '<blockquote>');
        html = html.replaceAll('[/quote]', '</blockquote>');

        content = html;
        return content;
    };

    $scope.bold = function () {
        $scope.inputTags('[b]', '[/b]');
    };

    $scope.italic = function () {
        $scope.inputTags('[i]', '[/i]');
    };

    $scope.strice = function () {
        $scope.inputTags('[s]', '[/s]')
    };

    $scope.insertSmile = function (smile) {
        var allMessage = $('#message').val();
        var positionStart = $('#message').prop('selectionStart');

        var startString = allMessage.substring(0, positionStart);
        var endString = allMessage.substring(positionStart, allMessage.length);

        $('#message').val(startString + smile + endString);
    };

    $scope.inputTags = function (tag1, tag2) {

        var allMessage = $('#message').val();
        var positionStart = $('#message').prop('selectionStart');
        var positionEnd = $('#message').prop('selectionEnd');

        var startString = allMessage.substring(0, positionStart);
        var midleString = allMessage.substring(positionStart, positionEnd);
        var endString = allMessage.substring(positionEnd, allMessage.length);

        $('#message').val(startString + tag1 + midleString + tag2 + endString);
    }
});
myApp.filter('unsafe', function($sce) { return $sce.trustAsHtml; });
String.prototype.replaceAll = function(search, replace){
    return this.split(search).join(replace);
};
