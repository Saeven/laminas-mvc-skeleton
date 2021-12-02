# saeven-laminas-mvc-skeleton

## Introduction

This is a skeleton application based on the Laminas MVC skeleton that adds AlpineJS, Twig, Doctrine, Circlical/User, Assetic, TailwindCSS and more!


https://user-images.githubusercontent.com/887224/144365412-049eeaab-2300-4144-b174-099d55d02e93.mov



## Installation

* Clone this project, composer install
* Create a MySQL database for the project
* Enter your database details into config/autoload/database.local.php
* Spawn your database tables with the Doctrine CLI

```bash
$ ./vendor/bin/doctrine-module orm:schema-tool:update --force
```

This ought to run 20 queries or so (at time of writing). With the tables in place with all rights granted to your user, issue this query:

```sql
INSERT INTO `skeleton`.`acl_roles` (`name`)
VALUES ('user')
```

Test it out immediately using PHP's built-in web server:

```bash
$ cd path/to/install
$ php -S 0.0.0.0:8080 -t public
# OR use the composer alias:
$ composer run --timeout 0 serve
```

This will start the cli-server on port 8080, and bind it to all network interfaces. You can then visit the site at http://localhost:8080/

- which will bring up this sample rig.

**Note:** The built-in CLI server is *for development only*.

## What it does

Load it up, register, and add/remove tokens to see how my circlical user, tailwind-forms and autowire library can interact with one another.  
