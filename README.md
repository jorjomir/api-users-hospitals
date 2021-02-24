# API to manage a patient/doctor persistence layer

To start the API:
 - Clone the repository
 - Run "composer install"
 - Create MySQL database ( the project uses InnoDB engine)
 - Run export.sql into it to import records
 - Edit [/Repository/Database](https://github.com/jorjomir/api-users-hospitals/blob/master/Repository/Database.php) constants for DB connection
 - Open Terminal/CMD in the root directory and type "php -S localhost:8080" to start local server.
 - Import the Postman collection for easier testing

There are descriptions in the more complicated Postman requests!
 
The condition of the task can be found [here](https://github.com/jorjomir/api-users-hospitals/blob/master/api-task.md).