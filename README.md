# Application Setup

- run composer install
- make sure .env is created
- make sure database is configured
- run php artisan key:generate
- run php artisan config:cache
- run php artisan migrate:fresh --seed
- run npm install
- run npm run dev
- run php artisan storage:link
  - https://laravel.com/docs/10.x/filesystem#the-public-disk
- run php artisan passport:install
  - make password client and token are in .env
- run php artisan passport:keys
- run npm run dev
- make sure APP_URL in the .env is set correctly
