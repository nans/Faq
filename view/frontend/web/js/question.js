define([
        'jquery',
        'ko',
        'jquery/ui',
        'mage/cookies'
    ], function ($, ko) {
        'use strict';

        return function (data, mainModel) {
            var self = this;
            self.questionId = Number(data.question_id);
            self.categoryId = Number(data.category_id);
            self.sortOrder = Number(data.sort_order);
            self.status = Number(data.status) === 1;
            self.title = data.title;
            self.content = data.content;
            self.usefulCount = ko.observable(Number(data.useful));
            self.uselessCount = ko.observable(Number(data.useless));

            self.getCookieName = function (type) {
                return 'faq_question_' + self.questionId + '_' + type;
            };

            self.getCookieValue = function (type) {
                var value = $.mage.cookies.get(self.getCookieName(type));
                return (value) ? value : false;
            };

            self.setCookieValue = function (type, value) {
                $.mage.cookies.set(self.getCookieName(type), value, {
                    lifetime: 604800
                });
            };

            self.useful = ko.observable(self.getCookieValue('useful'));
            self.useless = ko.observable(self.getCookieValue('useless'));

            self.changeFeedbackByParams = function (type, delta, callback) {
                $.ajax(
                    {
                        url: mainModel.getApiUrl() + 'question/' + type + '/' + self.questionId + '/delta/' + delta,
                        type: "GET",
                        cache: false,
                        success: function (result) {
                            if (result && typeof callback === 'function') {
                                callback();
                            }
                        }
                    }
                );
            };

            self.addUseful = function () {
                self.usefulCount(self.usefulCount() + 1);
            };

            self.removeUseful = function () {
                var value = self.usefulCount();
                if (value > 0) {
                    value--;
                }
                self.usefulCount(value);
            };

            self.addUseless = function () {
                self.uselessCount(self.uselessCount() + 1);
            };

            self.removeUseless = function () {
                var value = self.uselessCount();
                if (value > 0) {
                    value--;
                }
                self.uselessCount(value);
            };

            self.setUseful = function () {
                if (self.useful()) {
                    self.useful(false);
                    self.changeFeedbackByParams('useful', -1, self.removeUseful);
                } else {
                    self.useful(true);
                    self.changeFeedbackByParams('useful', 1, self.addUseful);

                    if (self.useless()) {
                        self.useless(false);
                        self.changeFeedbackByParams('useless', -1, self.removeUseless);
                    }
                }
            };

            self.setUseless = function () {
                if (self.useless()) {
                    self.useless(false);
                    self.changeFeedbackByParams('useless', -1, self.removeUseless);
                } else {
                    self.useless(true);
                    self.changeFeedbackByParams('useless', 1, self.addUseless);

                    if (self.useful()) {
                        self.useful(false);
                        self.changeFeedbackByParams('useful', -1, self.removeUseful);
                    }
                }
            };

            self.cookieUpdated = ko.computed(function () {
                self.setCookieValue('useless', self.useless());
                self.setCookieValue('useful', self.useful());
                return true;
            });

            self.getUsefulText = function () {
                return $.mage.__('Useful') + ': ' + self.usefulCount();
            };

            self.getUselessText = function () {
                return $.mage.__('Useless') + ': ' + self.uselessCount();
            };
        }
    }
);