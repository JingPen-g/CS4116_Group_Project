# Welcome to the Backend 
While the code may seem very confusing(and it is) using it should be super simple(or I have failed.)

## What are the Major Requirements of the Backend
Well really any and all database stuff, as well as routing. Of course it might handle user sessions and the like, but for now we will focus on database stuff and routing since thats the bulk of the backend

## What is routing?
For security, we don't want a client browser to be able to access every file in our project. 

What do we want them to access? 
- Front end pages, so pretty much anything in /front-end/
- api's so that they can request data, found in /back-end/api/

Routing also makes the user experience easier!
Instead of having to type in localhost:8080/front-end/create-account/pages/account_pages/create-account.php(just an example i know we dont actually do this) We can simply define a route localhost:8080/register which automatically provides the content in the long url version.
These routes are defined in routes/web.php. Be familiar with them! theyll come in handy.

## How do I access database data?
There are a few ways all currently viewable in front-end/home.php(accessible by localhost:8080/) and later will be moved to front-end/dev-test/home.php(accessible by localhost:8080/dev-test) when our front page actually has something.

This only shows examples for user table stuff, since this is the only part that has been devloped so far.
I will run through a high level idea for the structure so that after reading this you will always know how a specific table can be accessed and where to look to add features or fix bugs.

## High Level Explanation
The whole point of this is making your life, coding, easier.

To move data, as you know, you have to make a GET, POST or other request to some page.
Of course, we could make that page something displayable, but the standard is for requests to go through api's.

To make things as generic as possible, since not everything will be done when you're working on it, there is a structure to how these api's are laid out so you will always know where to look to pull data from or update a table.

in the /back-end/api/ folder there will be a .php for every table 
e.g.
- users.php
- business.php
- service.php
- etc.

These will always have the same structure so that how you access them stays the same, only the data needs to change.

Examples:
- Sending a GET request localhost:8080/api/users.php?name=Ben will give you back a user with the name Ben
- Sending a POST request to localhost:8080/api/users.php will always insert a user with the values specified since POST will always be for inserting into a table.

Once other tables have been added they will be similar
For Example: Sending a GET request to localhost:8080/api/business.php?id=1 will give you the business with id 1

## How does the magic happen?
This is where I'll explain how this all works, in case you want to add your own api's, change their behavior, or change the ORM for missing functionality.

Since this will explain the innards of the project, I will attempt to explain it as clearly as possible.

### 1. API Routes
Although they currently aren't structured like so, API's will be RESTful. I know that sounds confusing, but its actually quite simple. Its just a design method of making API's.

Practically, it means that each api will be able to accept GET, POST, PUT, DELETE.

GET requests will always be about getting data from the db. These might even have different options based on the passed values since you might want to GET a specific user, or you might want to GET a count of all users.

POST requests will always be about putting data in the db that wasn't there before. These will always be about inserting things in a table, so I don't think there will be several possibilites here, but there might be for your task.

PUT requests will always be about updating/modifying existing data. Think like updating a password or changing a business location.

DELETE requests will always be about deleting existing data. These will probably be a bit more rare, since we don't want to delete user accounts lol, but this might be used for things like deleting old advertisements.

To separate concerns, and make the actual api's more clean, we separate db interaction and the actual api's.
This means that you will never be making SQL or using mysqli in the actual api route.
Instead you should use the relevant classes or methods found in /back-end/db. But what the heck are those complicated files??

### 2. ORM
This is where the magic happens.

There are 2 main files/classes Database and Model. Database is a singleton(There can only be one database connection at a time.) Model is what every other table class extends e.g. Users or Business.

Model has the most generic functions e.g. find(to find data), insert(to insert data), update(to update data), etc.

I think this small Users class is a perfect example to showcase how they're used:

```
class Users extends Model {
    protected $table = "Users";

    public function getUser($name) {
        return $this->find(['Name' => $name]);
    }

    public function getUserCount(){
        return $this->count();
    }

    public function insertUser($name, $email, $password) {
        $insertableData = [
            'Name' => $name,
            'Email' => $email,
            'Password' => $password
        ];

        return $this->insert($insertableData);
    }
}

```

The first thing to do in one of these classes is to define the protected $table. This will be the table which the operations will change.

Now lets focus on getUser($name) method. as you can see it calls the find() method from Model. But what the heck is that array?? Well to make it generic i made the input a dictionary which accepts the column name as the key and the value as the value. Dont know what that means? Here: 
```
$this->find(['Column 1' => value1, 'Column 2' => value2])
```

Lets move on to insertUser($name, $email, $password). It works the same way as find() except this time its about inserting values. In this particular case we only accept a name, email and password and have to construct the data array accordingly.

All other classes should follow this general structure, with the aim of usage being the easiest possible. These classes, especially Model, is where all the confusing code should go, with the hopes that the front end code and api routes are fairly easy to read and use.
