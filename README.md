1. clone the project with "git clone https://github.com/MbilalS/adcashTask.git"
2. move to adcashTask folder and run "composer install". if you do not have composer installed in the system then you can install it from https://getcomposer.org/ 
3. run "copy .env.example .env"
4. php artisan key:generate
5. open .env file and update the following DB (create a database and add the name then DB DB_USERNAME and DB_PASSWORD)
        1. DB_DATABASE=adcash
        2. DB_USERNAME=root
        3. DB_PASSWORD=""
6. php artisan migrate
7. php artisan serve

then you can use postman to test the API's

json body while creating a Product
{
      "product_name": "product7",
      "category_id": 4
}

json body while updating a Product
{
    "product": {
      "id": 1,
      "name": "product1",
      "category_id": 1
    }
}

json body while creating a category
{
      "category_name": "category1"
}

json body while updating a category
{
    "category": {
      "id": 1,
      "name": "category1"
    }
}

and for concrete category, add the category name in the request like
http://127.0.0.1:8000/api/products/concrete-category?category_name=category1



For rining unit tests
1. .\vendor\bin\phpunit     OR     php artisan test
    

