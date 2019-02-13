define([
        'jquery',
        'ko',
        'jquery/ui'
    ], function ($, ko) {
        'use strict';

        return function (data) {
            var self = this;
            self.categoryId = Number(data.category_id);
            self.title = data.title;
            self.sortOrder = Number(data.sort_order);
            self.status = Number(data.status) === 1;
            self.questions = ko.observableArray([]);
           // self.colourClass = ko.observable();

            self.colourClass = function (index) {
                var colours = [
                    'caption caption-green',
                    'caption caption-red',
                    'caption caption-blue',
                    'caption caption-orange',
                    'caption caption-purple'
                ];

                if (index > colours.length) {
                    index = 1;
                }

                return colours[index];
            };

            self.fillQuestions = function (allQuestions) {
                for (var i = 0; i < allQuestions.length; i++) {
                    if (allQuestions[i].categoryId === self.categoryId) {
                        self.questions.push(allQuestions[i]);
                    }
                }
            };
        }
    }
);