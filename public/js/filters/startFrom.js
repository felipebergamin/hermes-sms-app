angular.module('hermes_app').filter('startFrom', function () {
    return function (input, start) {
        if(!input)
            return input;

        start = +start; //parse to int
        return input.slice(start);
    }
});