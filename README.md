# Project work 2: **Shadow Profiling** #

***

**Author:** Elisabeth Haberl, Austria (elisabeth.haberl@edu.fh-joanneum.at)

**Institution:** FH Joanneum

**Date:** January 2017

***

*Please find the installation and setup instructions in INSTALL.md :-)*

***

**Background:** Shadow profiling got viral in 2012 and 2013 when a Facebook leak revealed data of people, that should not be there (google "Facebook shadow profiling" for more detail). Social networks as well as sophisticated technologies made it easy to gather a lot of data of users sometimes without knowing or without permission.

**Motivation:** I want to make a difference. I want users to learn about possible data collecting techniques that happen unnoticed. And I want developers to think of how to treat users with developing features.
*Keep in mind:* The possibilities to collect all kind of data are there but that does not mean that they need to be used. And not everything collected must be stored.

**Prototype:** The prototype is an example of how user data can be collected and stored but only for the advantage of the user. Also the possibility for the user to inform oneself about the data collected and stored is new but might increase in importance. Joomla CMS and HikaShop Joomla-extension are used for ease of use.

## File structure and important files
* ProjectWorkPrototype: contains Joomla files for web server

* Database: contains SQL-files for importing into database (insert **only one file** -> take most recent one)

* ProjectWorkPrototype/projectwork_scripts: contains all files created by the author which contain the main logic of the prototype

* ProjectWorkPrototype/profiles: contains all profiles created by the scripts in projectwork_scripts


* ProjectWorkPrototype/components/com_hikashop/views/address/tmpl/form.php is the file which created the checkout form
  * search for "// START prototype"


* ProjectWorkPrototype/components/com_hikashop/views/product/view.html.php contains the insertion of the prototype-code
  * search for "// START prototype"


## Troubleshooting
* contact author for help -> elisabeth.haberl@edu.fh-joanneum.at

## Implemented functionality
1. **Cookie handling:** A cookie is set on each device, which doesn't change the value, to identify the device. The value acts as ID/name of the shadow profile.

2. **Detection of location:** A JS-Script gathers the current location, which is then sent to the server and stored in a shadow profile.

3. **Gathering of email-address:** The user can take part in a lottery by entering the email-address. The address is then sent to the server and stored in a shadow profile.

4. **Extraction of name:** If the email-address complies the requirements, the name is extracted on the server and stored in a shadow profile.

5. **Storing of recently viewed products:** A built-in feature of HikaShop shows recently viewed products in the sidebar. These products are then sent to the server and stored in the shadow profile.

6. **Checking for similarities:** A php-script on the server allows to check for similarities of the shadow profiles. The script checks for equality of the email-address, the name and the recently viewed products. A probability is determined and stored in the involved shadow profiles.

7. **Deleting of similarities:** As the script mentioned before is executed very often for testing purposes, it is necessary to delete all similarities of all shadow profiles.

8. **Prefilling of checkout fields:** The shadow profile belonging to the device is checked for existing data to be filled in in advance to make the checkout easier and not that time consuming for the customer. See ProjectWorkPrototype/components/com_hikashop/views/address/tmpl/form.php. This is the main goal of the project.
