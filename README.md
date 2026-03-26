# MobileChat
Giftogram Technical Assessment
### Setup:
Requirements PHP and MySQL
1. Create a mobile_chat database in MySQL
2. Import the tables using the sql dump file(UTF-8)
* Run the command

        mysql -u username -p mobile_chat < C:/path/to/sql_dump.sql
* Or run the SQL query in the mobile_chat database
3. Start the PHP server(ensure mysqli extension is enabled)

        php -S localhost:8000
### Name:
Kenneth Cheng
### How long it took:
~7h
### Steps Taken:
I began with establishing a connection between PHP and a MySQL database. After establishing the connection, I worked on turning the PHP application into an API that could pass queries to MySQL. I then decided to implement a simple routing file structure to keep things organized and modular. With this done, I could implement the rest of the endpoints, with the same parameters and response format as shown in the instructions. With all the core functionality complete, I added validation and error handling to improve usability.
### Issues with the endpoint structure:
* There are no sessions or JWT tokens returned once a user logs in
* There is no authentication for the send_message endpoint, allowing impersonation
* There are no PUT or DELETE endpoints, so users cannot be edited or removed
### Suggested improvements:
* Security:
    * Implement rate limiting
    * Use HTTPS
    * Password hashing
    * Validation of fields
* Usability:
    * JWT tokens for authentication
* API design:
    * user_id and message_id can be UUIDs instead of unsinged integers
    * The list_all_users endpoints can be split into one for admins and regular users
    * There is no password confirmation on registration