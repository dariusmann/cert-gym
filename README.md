## Installation

##### Auth.json for Spark before composer install
We're using spark in this project. It's a paid composer bundle and required authentication.
Just locate the auth.json with credentials in you root directory. After that you can run composer.

##### Install packages
- `sail composer install`
- `sail npm run install`

##### Configure .env
##### Run migrations
`sail artisan migrate`

##### Import questions data
- First locate categories.json and question directory in storage folder
- Then run this commands:
- `sail artisan app:import-all`


##### Create a test user with subscription
`sail artisan db:seed`

- User: test@dev.com
- Password: login123

### Configure .env for frontend
set `VUE_BACKEND_API_URL`
### Run frontend
sail npm run dev

### Stripe webhooks in development
`sail share --subdomain=cert-gym`

## Useful resources

#### Debugging 

Follow this blog: https://blog.stackademic.com/debugging-laravel-sail-with-xdebug-3-in-phpstorm-2023-a-detailed-guide-84a594c09586



## Deployment
### Laravel Forge

#### App key has to be generated
execute command in forge on prod

`php artisan key:generate`

#### How to configure compose auth.json (e.g. spark)
https://forge.laravel.com/docs/servers/packages.html

#### Configuring a domain
https://forge.laravel.com/docs/sites/the-basics.html#default-sites



