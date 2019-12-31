# Magento 2 - FAQ extension  
![Sample](https://github.com/nans/devdocs/blob/master/Faq/Frontend.png "Frontend")  
* Admin can create, update, delete questions and categories.  
* Admin can add FAQ section to pages via widget.

## Admin Panel  
![Sample](https://github.com/nans/devdocs/blob/master/Faq/Admin_Categories.png "Categories page")  
![Sample](https://github.com/nans/devdocs/blob/master/Faq/Admin_Category_Form.png "Category Edit Form")  
![Sample](https://github.com/nans/devdocs/blob/master/Faq/Admin_Questions.png "Questions Page")  
![Sample](https://github.com/nans/devdocs/blob/master/Faq/Admin_Question_Form.png "Question Edit Form")  

# Supported  
Magento 2.1.x - 2.3.x  
PHP 7.0 and higher  

# Installation Instruction  
* Copy the content of the repo to the Magento 2: app/code/Nans/Faq
* Run command: php bin/magento setup:upgrade
* Run Command: php bin/magento setup:static-content:deploy
* Now Flush Cache: php bin/magento cache:flush

# Support
If you encounter any problems or bugs, please open an [issue](https://github.com/nans/Faq/issues) on GitHub.

#Versions  
## 0.0.3
* Removed static faq page  
* Added widget  
* Added CMS page  


