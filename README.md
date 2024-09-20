php artisan make:controller UserController 
php artisan make:model Country -m     
php artisan make:model State -m     
php artisan make:model City -m  
php artisan make:seeder CountryStateCitySeeder    
php artisan db:seed --class=CountryStateCitySeeder
php artisan storage:link
