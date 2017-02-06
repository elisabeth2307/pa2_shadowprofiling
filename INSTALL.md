# **Set up of environment**

## File structure
* ProjectWorkPrototype: contains Joomla files for web server
* Database: contains SQL-files for importing into database (insert **only one file** -> take most recent one)

## Instructions
1. Upload the folder "ProjectWorkPrototype" to a **web server** (contains Joomla files) (hint: use XAMPP for local usage). If you use XAMPP, you don't have to copy the folder into "htdocs" but you can create an alias and a link which makes it easier if you work with a repository.

2. Import data from "Database" folder into your **database** -> name of database must be configured/checked in ./ProjectWorkPrototype/configuration.php (variable is named "db"). Database in this example is named "ProjectWorkPrototype".

3. Change the **database configuration** in ./ProjectWorkPrototype/configuration.php (host, user, password).

4. The system should work now! :-) Since there happen almost always some unexpected failures (or maybe I also have forgotten to mention something), contact the author for help or suggestions for improvement.

5. The **cookie** that is set for shadow profiling depends on the Joomla cookie. If you can access the web shop, take a look at the cookies set. There should be one from Joomla with a random chosen name. In the example it is "5954872f5836ba36117eac10a7c8bd93". Copy the name of this main Joomla cookie and paste the value into the file "./ProjectWorkPrototype/prototype_variables.php" for the key "$joomlaCookie" which is the first variable in that file. If you don't do this, it doesn't work like it should.


**I hope you consider my work as useful and inspiring. As I intimated in README.md, I want to set a sign and to make a difference. Be part of this difference and make the world a better place :-)**
