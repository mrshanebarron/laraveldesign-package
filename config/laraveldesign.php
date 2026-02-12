<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Layout Configuration
    |--------------------------------------------------------------------------
    |
    | The layout that Laravel Design views will extend. This should be the
    | name of your main application layout file.
    |
    */
    'layout' => 'layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Content Section
    |--------------------------------------------------------------------------
    |
    | The section name where content should be yielded in your layout.
    |
    */
    'content_section' => 'content',

    /*
    |--------------------------------------------------------------------------
    | Blog Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for the blog functionality.
    |
    */
    'blog_prefix' => 'blog',
    'blog_title' => 'Blog',
    'posts_per_page' => 10,

    /*
    |--------------------------------------------------------------------------
    | Media Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for media uploads and storage.
    |
    */
    'media' => [
        'disk' => 'public',
        'directory' => 'media',
        'max_size' => 51200, // 50MB in KB
        'allowed_types' => [
            'image/*',
            'video/*',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Locations
    |--------------------------------------------------------------------------
    |
    | Define the available menu locations for your theme.
    |
    */
    'menu_locations' => [
        'header' => 'Header Menu',
        'footer' => 'Footer Menu',
        'sidebar' => 'Sidebar Menu',
    ],

    /*
    |--------------------------------------------------------------------------
    | Page Templates
    |--------------------------------------------------------------------------
    |
    | Define available page templates. The key is the template file name
    | (without .blade.php) and the value is the display name.
    |
    */
    'page_templates' => [
        'default' => 'Default',
        'home' => 'Homepage',
        'full-width' => 'Full Width',
        'sidebar' => 'With Sidebar',
    ],
];
