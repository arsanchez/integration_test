## MailerLite Integration

This is a Mailerlite integration test written by Argenis Sánchez, below you can find the install and testing instructions.

1. Git checkout or download the project code from https://github.com/arsanchez/integration_test

2. 'cd' into the project folder

3. Run 

   ```bash
   composer install
   ```

4. Install and compile the assets using Mix by running 

   ```bash
   npm install && npm run dev
   ```

5. Create encryption key if needed 

   ```bash
   php artisan key:generate
   ```

6. Locate and run the 'mailerlite_manager_2021-08-02.sql' sql script located in the 'database' folder of the application

7. Serve the application, from the application root folder run 

   ```bash
   php artisan serve
   ```

8. The application should be running at http://localhost:8000/ or http://127.0.0.1:8000/

## Running the tests

In order to run the test in this project you have to do the following:

1. CD into the project root directory

2. Run the tests

   ```bash
   php artisan test
   ```

