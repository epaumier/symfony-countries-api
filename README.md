# symfony-countries-api

1. create .env file with your DB info:

    ```
    APP_ENV=dev

    # replace user,pw and dbname
    # you must configure your server version
    DATABASE_URL=mysql://user:pw@127.0.0.1:3306/dbname?serverVersion=5.7
    ```

2. Install composer packages:
    
    ```
    composer i
    ```

3. Populate Database with corresponding fields:
    
    ```
    php bin/console make:migration
    ```

4. Run command to fill database with data:
    
    ```
    php bin/console store-countries ./src/Command/countries.json
    ```

5. Browse to [localhost:8000/country](localhost:8000/country) to view the list of countries in original formatting.