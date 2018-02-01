define([
        'jquery',
        'ko',
        'jquery/ui'
    ], function ($, ko) {
        'use strict';

        return function (data) {
            var self = this;
            self.questionId = Number(data.question_id);
            self.sortOrder = Number(data.sort_order);
            self.status = Number(data.status) === 1;
            self.title = data.title;
            self.content = data.content;
            self.useful = ko.observable(Number(data.useful));
            self.useless = ko.observable(Number(data.useless));
        }
    }
);