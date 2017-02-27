<h1 align="center">Easel</h1>

<p align="center">A minimal blogging package for Laravel</p>

<div align="center">
    <img src="https://raw.githubusercontent.com/talvbansal/easel/gh-pages/images/Editor.png" alt="Editor" width="600"/>
</div>

<br>

<div align="center">

    <a href="https://travis-ci.org/talvbansal/easel" target="_blank">
        <img src="https://api.travis-ci.org/talvbansal/easel.svg" alt="Build Status" />
    </a>
    
    <a href="https://styleci.io/repos/63001540" target="_blank">
        <img src="https://styleci.io/repos/63001540/shield?style=flat" alt="Style CI" />
    </a>
    
    <a href="https://github.com/talvbansal/easel/issues" target="_blank">
        <img src="https://img.shields.io/github/issues/talvbansal/easel.svg" alt="Issues" />
    </a>
    
    <a href="https://packagist.org/packages/talvbansal/easel" target="_blank">
        <img src="https://poser.pugx.org/talvbansal/easel/downloads" alt="Downloads" />
    </a>
    
    <a href="https://insight.sensiolabs.com/projects/06d23269-ac1d-4465-b542-9c38b31f8d91" target="_blank">
        <img src="https://img.shields.io/sensiolabs/i/06d23269-ac1d-4465-b542-9c38b31f8d91.svg?style=flat" alt="SensioLabsInsight"/>
    </a>
    
    <a href="https://github.com/talvbansal/easel/blob/master/licence" target="_blank">
        <img src="https://poser.pugx.org/talvbansal/easel/license" alt="License" />
    </a>
</div>


<h3>Requirements</h3>

- [PHP](https://php.net) >= 7.0
- [Composer](https://getcomposer.org)
- An existing [Laravel 5.3 ](https://laravel.com/docs/master/installation) project


<h3>Installation</h3>

1. You can download Easel using composer 

    ```bash
    composer require talvbansal/easel
    ```

2. To register the `easel:install` and `easel:update` artisan commands as well as the new routes for Easel to work, you will need to add the Easel service provider to your `config/app.php` file

    ```php
    \Easel\Providers\EaselServiceProvider::class,
    ```

3. To install Easel into your project run the following command, this will publish all the application assets and database migrations / factories / seeds required, the migrations will automatically be run from this command

    ```bash
    php artisan easel:install
    ```

4. Finally you'll need to seed your database to create the default admin user and initial post

    ```bash
    php artisan easel:seed
    ```
5. Update your `config/auth.php` file to use Easel's built in User Model (`Easel\Models\User`) 
	```php
        'providers' => [
            'users' => [
                'driver' => 'eloquent',
                'model' => Easel\Models\User::class,
            ],
        ],
	```
    Or alternatively configure Easel to use your own [Custom User Model](#Custom-Model)

6. Sign into Easel using the default credentials:
    - Email `admin@easel.com`
    - Password `password`
    
7. Head over to the profile page and update your details and password!

8. Start blogging! 

### Updates

- Whenever an update to Easel is made internal files will automatically be updated when a composer update is run, however new views and assets will only be published / republished with the following command
    
        php artisan easel:update
    
- You could also add the above command to your post-update-cmd in your projects `composer.json` file
	```javascript
        "post-update-cmd": [
            "Illuminate\\Foundation\\ComposerScripts::postUpdate",
            "php artisan easel:update",
            "php artisan optimize"
        ]
   ```

### Customisation

Every app is different and Easel has been designed to be customisable. Be sure to check out the `config/easel.php` for a complete list of configurable options. 

#### User Models

- Since Easel is designed to be the starting point for a new project or added into an existing one, you can decide to use the built in `User` model (`Easel\Models\User`) or use an existing `User` model with a few alterations. 

- ##### Built In Model

- If you want to use the build in User model (`Easel\Models\User`) you'll need to set it in the `config/auth.php` file
	```php
        'providers' => [
            'users' => [
                'driver' => 'eloquent',
                'model' => Easel\Models\User::class,
            ],
        ],
    ```

- ##### Custom Model

If you want to use an existing model you'll need to make the following changes to it: 

1. Your User model will need implement the `Easel\Models\BlogUserInterface` and also use the `Easel\Models\EaselUserTrait`
2. You will also need to add the key `birthday` to the `$dates` property of your user model
	```php
        class User extends Model implements \Easel\Models\BlogUserInterface{
        
            use Easel\Models\EaselUserTrait;
        
            protected $dates = ['birthday'];
            
        }
    ```
    
3. Then finally update the `config/easel.php` config file use your User model
 
    ```php
    'user_model' => \My\Custom\User::class,
    ```
    

#### Customising the url prefix for the blog

By default you can access the blog list and posts at the following routes:
```bash  
	/blog
	/blog/{blog-post-slug}
```
However you might want the blog to accessed from a different URI, Easel lets you configure that by adding the following key `BLOG_BASE_URL` to your `.env` file, for example:
```bash
	BLOG_BASE_URL=/myblog
 ```
 
The above changes will make your blog respond at 
   
```bash
	/myblog
	/myblog/{blog-post-slug}
```
If you want the blog to respond at the `'/'` route you will need to add a new route to your `routes.php` file as follows:

```php
	Route::get('/', '\Easel\Http\Controllers\Frontend\BlogController@index');
```
	
#### Customising views for your blog posts and list

When creating a blog post you can use the `default` layout for Easel, however it is likely that you'll want to amend the views to suit your application. 
You may also need different views for different blog posts - Easel has you covered! just add the `BLOG_POST_LAYOUTS` key to your `.env` file and give it the path to a folder within your `resources/views` folder

For example
```bash
	BLOG_POST_LAYOUTS=layouts.blog.posts
```
Will point to the following folder
```bash
	{project}/resources/views/layouts/blog/posts
```
 - Every blade template within that folder will then be listed on the post creation page as a potential layout for that post. 
 - Sub-folders within the `BLOG_POST_LAYOUTS` folder will __not__ be listed allowing you to store partials for your templates within that single folder structure.

You can also set the blog post list layout using the `BLOG_POST_LIST` key, which again points to a corresponding view within your `resources/views` folder
```bash
	BLOG_POST_LIST=layouts.blog.list
```