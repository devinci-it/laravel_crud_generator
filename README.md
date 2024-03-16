# Laravel CRUD Generator Library

The **laravel_crud_generator** library is a Laravel package that provides a convenient way to generate custom Laravel class repositories. With this library, users can easily create repositories containing basic CRUD (Create, Read, Update, Delete) operations.

## Installation

To use this library, follow these steps:

1. Clone the repository from GitHub:

   ```bash
   git clone https://github.com/your-username/laravel_crud_generator.git
   ```

2. Note the path into the cloned directory:

   ```bash
   pwd laravel_crud_generator
   ```

3. In your Laravel project's `composer.json` file, add the following to the `repositories` array:

   ```json
   "repositories": [
       {
           "type": "path",
           "url": "/path/to/laravel_crud_generator"
       }
   ]
   ```

   Replace `/path/to/laravel_crud_generator` with the actual path to the cloned library on your local system.

4. Require the package in your Laravel project:

   ```bash
   composer require devinci/laravel-utils="dev/main"
   ```

   This will ensure that the library is installed and available for use within your Laravel project.

## Usage

Once the library is properly installed and configured, you can use the following command to generate a repository:

```bash
php artisan make:repository {model} {name?}
```

Replace `{model}` with the name of your model and `{name}` (optional) with the desired name for the repository class. This command will create a repository class containing basic CRUD operations for the specified model.

## Note

Please note that this library is currently only available on GitHub. You need to clone the repository and follow the installation steps mentioned above to use it in your Laravel project. Make sure you have a Laravel project set up before installing the library.

For more information or to report any issues, please visit the [laravel_crud_generator GitHub repository](https://github.com/devinci-it/laravel_crud_generator).
