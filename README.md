## About this application

This app was built to present myself to the world of recruiters and
job opportunities without having to rewrite it everytime. It gives public
visibility into who I am, my experience, and what I have to offer. You
can find my contact info as well as my skills and experience at
https://richardjacobsen.org/ 


## To preview this code:

- clone this repository locally
- create a `.env` from the `env.example` and fill in the `ADMIN_` variables with your info
- run `composer install`
- run `php artisan key:generate`
- make sure to have a database configured, and add it to the `.env`
- to make use of https://mailcatcher.me/, make sure it is installed locally
- to run this site locally, I recommend using https://laravel.com/docs/11.x/valet
- run `php artisan migrate`
- run `php artisan db:seed --class=AdminUserSeeder`
- make sure to have `npm` and `nodejs` installed
- run `npm install && npm run build`
- visit the site locally
  - if using `valet`, simply run `valet secure resume` to use `https`, and visit `https://resume.test`

### Feel free to download and preview this site and code to build the site.
