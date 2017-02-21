# Project work 2: **Shadow Profiling** #

***

**Author:** Elisabeth Haberl, Austria (elisabeth.haberl@edu.fh-joanneum.at)

**Institution:** FH Joanneum

**Date:** Oct 2016 - Feb 2017

***

*Please find the installation and setup instructions in INSTALL.md :-)*

***

**Background:** Shadow profiling got viral in 2012 and 2013 when a Facebook leak revealed data of people, that should not be there (google "Facebook shadow profiling" for more information). Social networks as well as sophisticated technologies make it easy to gather a lot of user data without knowing or without permission.

**Motivation:** I want to make a difference. I want users to learn about possible data collecting techniques that happen unnoticed. And I want developers to think of how to treat users correctly with help of developing features.
*Keep in mind:* The possibilities to collect all kind of data are there but that does not mean that they need to be used. And not every data collected must be stored.

**Prototype:** The prototype is an example of how user data can be collected and stored but only for the advantage of the user. Also the possibility for the user to inform oneself about the data collected and stored is new but might increase in importance. Joomla CMS and HikaShop Joomla-extension are used for ease of use.

## File structure and important files
* ProjectWorkPrototype: contains Joomla files for web server

* Database: contains SQL-files for importing into database (insert **only one file** -> take the most recent one)

* ProjectWorkPrototype/projectwork_scripts: contains all files created by the author which contain the main logic of the prototype

* ProjectWorkPrototype/profiles: contains all profiles created by the scripts in projectwork_scripts


* ProjectWorkPrototype/components/com_hikashop/views/address/tmpl/form.php is the file which created the checkout form
  * search for "// START prototype"


* ProjectWorkPrototype/components/com_hikashop/views/product/view.html.php contains the insertion of the prototype-code
  * search for "// START prototype"


* ProjectWorkPrototype/prototype_variables.php contains variable which can be changed e. g. Joomla Cookie


## Troubleshooting
* contact author for help -> elisabeth.haberl@edu.fh-joanneum.at

## Implemented functionality
1. **Cookie handling:** A cookie is set on each device, which doesn't change the value, to identify the device. The value acts as ID/name of the shadow profile.

2. **Detection of location:** A JS-Script gathers the current location, which is then sent to the server and stored in a shadow profile.

3. **Gathering of email-address:** The user can take part in a lottery by entering the email-address. The address is then sent to the server and stored in a shadow profile.

4. **Extraction of name:** If the email-address complies the requirements, the name is extracted on the server and stored in a shadow profile.

5. **Storing of recently viewed products:** A built-in feature of HikaShop shows recently viewed products in the sidebar of the website. These products are retrieved and stored in the proper shadow profile.

6. **Checking for similarities:** A php-script on the server allows to check for similarities of the shadow profiles. The script checks for equality of the email-address, the name and the recently viewed products. A probability is determined and stored in the involved shadow profiles.

7. **Deleting of similarities:** As the script which was mentioned before is executed very often for testing purposes, it is necessary to have the possibility to delete all similarities of all shadow profiles. (E. g. file 123.json has stored file 456.json as similar profile with a probability of 75. After removing the value 'similarities' and all child items will not be available anymore in the shaodw profiles.)

8. **Prefilling of checkout fields:** The shadow profile belonging to the device is checked for existing data to be filled in in advance to make the checkout easier and not that time consuming for the customer. See ProjectWorkPrototype/components/com_hikashop/views/address/tmpl/form.php. This is the main goal of the project.


## Adapt functionality to other systems
It is possible to adapt the functionality to other systems but it needs some knowledge. The code from ProjectWorkPrototype/components/com_hikashop/views/address/tmpl/form.php and ProjectWorkPrototype/components/com_hikashop/views/product/view.html.php needs to be inserted into the other system which might not work without changes (especially form.php). But if the file structure of profiles and projectwork_scripts is same, at least the self created scripts should work. Of course all the used paths must be checked if they are valid.

### CSS adaptions
If you want to modify the layout, make your changes in "ProjectWorkPrototype/templates/protostar/css/template.css" which is the stylesheet of the used template. If you want to use another template, you have to use another stylesheet of course.
