Hello, here is the local execution guide for the "Le Quai Antique" web application!
Be sure to follow these steps to set up the development environment properly.


Prerequisites:
Before you begin, make sure you have the following installed on your machine:

PHP (version 8.2.6 or higher)
MySQL (version 5.7.24 or higher)
A local web server (e.g. Apache)


Installation steps:

1. Clone this GitHub repository to your local machine:
git clone https://github.com/aureliencolusso/le-quai-antique.git

2. Import the database:
Open your MySQL client and connect to your database server.
Create a new database for the application.
Import the database backup file (lequaiantique.sql) into your newly created database.

3. Configuring the database connection:
Open the file (connection_bdd.php) in your application directory.
Modify the connection parameters ($host, $username, $password, $dbname) to match your MySQL configuration.

4. Start the local web server:
Make sure your local web server (eg Apache) is running.
Place the web application content in the appropriate directory for the web server to access.

5. Access the application:
Open your browser and access the local URL corresponding to your development environment (for example : http://localhost/lequaiantique/index.php).

You should now see the web application running.


Back office access:
Once the web application is running locally, you can access the back office as an administrator by following these steps:

Access the back-office login page by clicking on the login icon or by adding "/login.php" to the application URL (for example : http://localhost/lequaiantique/login.php ).

Use the credentials of the "administrator" account that I created by default.

Email: admin@lequaiantique.fr
Password: admin

Once logged in, you will find a new icon and a new "Administration" link in the navigation bar, allowing you to access the administration panel. In this panel you will find the possibility to manage the image gallery by having the possibility to add, modify or delete images, titles and descriptions.
You will also find the possibility of modifying the restaurant's schedules and also displaying or deleting the users created in the database.

Then, do not hesitate to disconnect from the administrator account by clicking on the "Disconnect" button in your profile in order to be able to create other classic users using the registration form located in the "Registration" navigation bar or by typing "/register.php" in the URL.

You will also be able to create reservations and find the summary on the confirmation page, where you will have the possibility to delete them.

By the way, if you are logged into your user or administrator account, the user information will be pre-filled by default in the reservation form in order to save time.

Thank you for viewing this README file. I hope this information has been useful for you to understand and use my application. If you have any additional questions or run into any issues, please don't hesitate to contact me.

I am available to help you and improve your experience with my application.

Good use !

Aurélien Colusso
