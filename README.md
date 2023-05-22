# theCoffeeHouse
backend:
    composer create-project laravel/laravel backend
 
    cd backend

    composer require twilio/sdk   cài twilio package

    php artisan migrate   taọ bảng trong csdl

    php artisan db:seed   seed dữ liệu mẫu
 
    php artisan serve