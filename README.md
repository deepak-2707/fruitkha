Clone the project by using command #git clone https://github.com/deepak-2707/fruitkha.git OR git clone git@github.com:deepak-2707/fruitkha.git

Goto inside the folder # cd /fruitkha

Run the command for dependency # composer install

Change the database details in .env file 
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=fruitkha
    DB_USERNAME=root
    DB_PASSWORD=

Change the paypal client id & secret key from .env (you will get from <a href="https://developer.paypal.com/tools/sandbox/accounts/">https://developer.paypal.com/tools/sandbox/accounts/</a>)
    PAYPAL_MODE=sandbox
    PAYPAL_SANDBOX_CLIENT_ID= your_client_id 
    PAYPAL_SANDBOX_CLIENT_SECRET= your_client_secret

Run the command to migrate table into database #php artisan migrate
Run the project by using command #php artisan serve


For Paypal Login
    email: sb-rsweb12497903@personal.example.com
    password: dvX9_o9d
    
Card Detals
    Phone: 2082792722
    Account type: Personal
    Account ID: WHLSJDW6W2LAY
    Country: IN
    Bank account number: 28505261
    Bank routing number: ICIC0000212
    Credit card number: 4311194065123892
    Credit card type: VISA
    Expiration date: 02/2027    
