json files are saved storage/jsonFiles directory thus no need for database config

data is fetched directly from json files without modeling

logic is located in DataController

run the app:
    
    composer install
    
    php artisan serve
    
    localhost/api/list : to list all surveys
    
    click on a survey to see its aggregated data
