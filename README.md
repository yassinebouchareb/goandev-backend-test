## GO&DEV Movies App
    ![preview](https://github.com/yassinebouchareb/goandev-backend-test/assets/40309534/0c9de779-5e25-4abb-90b2-427d39209163)

    This is a simple application that have a console command to fetch movies and genres from The Database Movies API and store them in Database, the project is running over Dockeer using Laravel Sail.
    The app Has 2 pages : 
        - List of all movies from the database using paginations, live search and filter by genre
        - Movie detail's page to display a movie from TMDB API
        
## Installation Steps
    - Clone project and cd to the project's folder
    - Copy .env.example to .env manually or using the linux command : `cp .env.example .env`
    - Change DB credentials in .env file to this : 
        DB_CONNECTION=mysql
        DB_HOST=mysql
        DB_PORT=3306
        FORWARD_DB_PORT=3307
        DB_DATABASE=movies_db
        DB_USERNAME=sail
        DB_PASSWORD=password
        
    - Add TMDB_API_KEY to the .env file, you can use my Key: eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJkZTg4ZmJlODIxOGFjNTUwNzQ3NzJhZWMwOGMzZGJmMiIsInN1YiI6IjVlN2JkYzFmNmM3NGI5NGU5NWM5MGVlYiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.V7zby7Pzza2paODnzTr4Moqg4yNK2njKx_MqIugsWhg
    
    - Install project dependencies by running this command (copy and paste everything into your terminal) : 
        docker run --rm \
            -u "$(id -u):$(id -g)" \
            -v "$(pwd):/var/www/html" \
            -w /var/www/html \
            laravelsail/php83-composer:latest \
            composer install --ignore-platform-reqs

    - After the dependecies are installed, you can start your Docker containers in the background using this command : ./vendor/bin/sail up -d
    - Generate a Laravel app key using this command : ./vendor/bin/sail artisan key:generate
    - Install node dependencies using : ./vendor/bin/sail npm i
    - Run migrations : ./vendor/bin/sail artisan migrate

### Important
 Before you visit the application in you browser, run this custom command to fetch movies and genres and store them in the database, so you will have some data when you open the app in the browser.
    ./vendor/bin/sail artisan app:fetch-movies-and-genres
 
### Run Application
    Make sure laravel sail is runing and simply visit the url localhostin your browser
 
      
    
    
