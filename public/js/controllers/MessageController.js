var myApp=angular.module('myApp');
myApp.controller('MessageController',  function($scope) {
    $scope.replaceSmile = function (content) {
        var html = $scope.textContent;
        if(html == undefined) {
            return '';
        }
        html = html.replaceAll(':-)', '<img src="/smiles/smiles/smile.gif"/>');
        html = html.replaceAll('[b]', '<b>');
        html = html.replaceAll('[/b]', '</b>');
        html = html.replaceAll('[s]', '<strike>');
        html = html.replaceAll('[/s]', '</strike>');
        html = html.replaceAll('[i]', '<i>');
        html = html.replaceAll('[/i]', '</i>');
        content = html;
        return content;
    };
    
    $scope.bold = function () {
        inputTags('[b]', '[/b]');
    };

    $scope.italic = function () {
        inputTags('[i]', '[/i]');
    };

    $scope.strice = function () {
        inputTags('[s]', '[/s]')
    };
    
    inputTags = function (tag1, tag2) {

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
