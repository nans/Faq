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

            self.categoryLoaded = ko.observable(false);
            self.questionLoaded = ko.observable(false);

            self.dataLoaded = ko.computed(function () {
                if (self.categoryLoaded() && self.questionLoaded()) {
                    self.addQuestionsToCategories();
                    return true;
                }
                return false;
            });

            self.sortOrder = function (firstRecord, secondRecord) {
                return firstRecord.sortOrder - secondRecord.sortOrder;
            };

            self.getApiUrl = function () {
                return self.baseUrl + config.apiUrl;
            };

            self.getRecordsByType = function (type, callback) {
                $.ajax(
                    {
                        url: self.getApiUrl() + type + '/' + self.storeId,
                        type: "GET",
                        cache: false,
                        success: function (result) {
                            callback(result);
                        }
                    }
                );
            };

            self.fillCategories = function (data) {
                for (var i = 0; i < data.length; i++) {
                    self.categories.push(new category(data[i]));
                }
                self.categories.sort(self.sortOrder);
                self.categoryLoaded(true);
            };

            self.fillQuestions = function (data) {
                for (var i = 0; i < data.length; i++) {
                    self.questions.push(new question(data[i], self));
                }
                self.questions.sort(self.sortOrder);
                self.questionLoaded(true);
            };

            self.fillDataByApi = function () {
                self.getRecordsByType('category', self.fillCategories);
                self.getRecordsByType('question', self.fillQuestions);
            };

            self.addQuestionsToCategories = function () {
                for (var i = 0; i < self.categories().length; i++) {
                    self.categories()[i].fillQuestions(self.questions());
                }
            };

            self.getConfig = function () {
                return config;
            };

            self.fillDataByApi();
        }
    }
);