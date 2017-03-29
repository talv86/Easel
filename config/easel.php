<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Blog Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can define the user model that Easel uses.
    |
    */
    'user_model'          => \Easel\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Blog Meta Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the blog meta tags for your application.
    | These will be used for web scraping and open graph tags
    | on sites such as Facebook and Twitter.
    |
    */
    'name'                => 'Easel',
    'title'               => 'Easel',
    'subtitle'            => 'Minimal Blogging Package',
    'description'         => 'A blogging package for your laravel app',
    'author'              => 'Talv Bansal',

    /*
    |--------------------------------------------------------------------------
    | Blog Post Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure the base uri where the blog should respond.
    | Indicate how many posts you would like to appear on each page.
    | If you are using Disqus, provide the identifier here or in
    | your host application's .env file
    |
    */
    'blog_base_url'       => env('BLOG_BASE_URL', '/blog'),
    'disqus_name'         => env('BLOG_DISQUS_NAME', null),
    'google_analytics_id' => env('GOOGLE_ANALYTICS_ID', null),
    'posts_per_page'      => 6,

    /*
    |--------------------------------------------------------------------------
    | Uploads Configuration
    |--------------------------------------------------------------------------
    |
    | Specify what type of storage you would like for your application. Just
    | as a reminder, your uploads directory MUST be writable by the
    | web server for the uploading to function properly.
    |
    | Supported: "public"
    |
    */
    'uploads'             => [
        'storage' => 'public',
        'webpath' => '/storage/',
    ],
];
