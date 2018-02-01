define([
        'jquery',
        'ko',
        'category',
        'question',
        'jquery/ui'
    ], function ($, ko, category, question) {
        'use strict';

        return function (config) {
            var self = this;
            self.baseUrl = config.baseUrl;
            self.apiUrl = config.apiUrl;
            self.storeId = config.storeId;
            self.categories = ko.observableArray([]);
            self.questions = ko.observableArray([]);

            self.getRecordsByType = function (type, callback) {
                $.ajax(
                    {
                        url: self.baseUrl + config.apiUrl + type + '/' + self.storeId,
                        type: "GET",
                        cache: false,
                        success: function (result) {
                            console.log('success');
                            callback(result);
                        }
                    }
                );
            };

            self.fillCategories = function (data) {

                for (var i = 0; i < data.length; i++) {
                    self.categories.push(new category(data[i]));
                }

            };

            self.fillQuestions = function (data) {
                for (var i = 0; i < data.length; i++) {
                    self.questions.push(new question(data[i]));
                }
            };

            self.fillDataByApi = function () {
                self.getRecordsByType('category', self.fillCategories);
                self.getRecordsByType('question', self.fillQuestions);
            };

            self.fillDataByApi();
        }
    }
);