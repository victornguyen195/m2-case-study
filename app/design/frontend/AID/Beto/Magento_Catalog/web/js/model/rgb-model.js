define(
    ['ko'],
    function (ko) {
        'use strict';

        let red = ko.observable(0);
        let blue = ko.observable(0);
        let green = ko.observable(0);

        function randomNumber() {
            return Math.floor((Math.random() * 255) + 1);
        }

        function updateColour() {
            red(randomNumber());
            blue(randomNumber());
            green(randomNumber());
        }

        return {
            randomNumber: randomNumber,
            updateColour: updateColour,
            red: red,
            blue: blue,
            green: green
        };
    }
);
