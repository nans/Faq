<?php

namespace Nans\Faq\Helper;

class Constants
{
    const DB_PREFIX = 'nans_';
    const FRONTEND_ID = 'id';

    const ACL_MAIN = 'Nans_Faq::main_content';

    const ACL_CATEGORY_VIEW = 'Nans_Faq::category';
    const ACL_CATEGORY_DELETE = 'Nans_Faq::category_delete';
    const ACL_CATEGORY_SAVE = 'Nans_Faq::category_save';

    const ACL_QUESTION_VIEW = 'Nans_Faq::question';
    const ACL_QUESTION_DELETE = 'Nans_Faq::question_delete';
    const ACL_QUESTION_SAVE = 'Nans_Faq::question_save';
}