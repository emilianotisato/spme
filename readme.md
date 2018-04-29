# Requirements


# Installation

If you wanna use homestead, just edit your Homestead.yaml file in the root of the project and add your desired dev domain. Don't forget to edit your /etc/hosts file to point the IP

Run `composer install` to get all the packages.
Run `npm install & npm run dev` to get all npm packages and compile.

# Testing

Create a database/testing.sqlite file

Then run the migrations for that:

```shell
php artisan migrate:fresh --database sqlite_testing
```
