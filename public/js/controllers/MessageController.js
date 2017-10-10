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
        html = html.replaceAll('[s]', '<s>');
        html = html.replaceAll('[/s]', '</s>');
        content = html;
        return content;
    }
});
myApp.filter('unsafe', function($sce) { return $sce.trustAsHtml; });
String.prototype.replaceAll = function(search, replace){
    return this.split(search).join(replace);
};
