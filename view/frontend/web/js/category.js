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
        }
    }
);