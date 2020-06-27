
## About Property System

- Property Listing with search and filter option
- Property Add,Edit & Delete functions
- Property Fetch from API 
- On fetch property from API it will create or update record in local database
- Image upload with generate thumbnail 
- Auto generate UUID for property

## Install Property System(Laravel)


- Run command `composer update` at root of project folder to install or setup project
- Create database and set credential in .env file at root of project folder 
- Run command `php artisan migrate` to migrate/setup tables


## Important config/.env variables


API_KEY='3NLTTNlXsi6rBWl7nYGluOdkl2htFHug' <br />
API_MAX_CALL=5 <br />
API_PER_PAGE=100 <br />
DATA_LISTING_PER_PAGE=10 <br />
API_BASE_URL='http://trialapi.craig.mtcdevserver.com/api' <br />
