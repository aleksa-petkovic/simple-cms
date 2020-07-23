<?php

declare(strict_types=1);

return [

    'module' => 'Articles',

    'titles' => [
        'index' => 'Articles',
        'create' => 'Create a new article',
        'edit' => 'Edit',
        'delete' => 'Delete',
    ],

    'index' => [
        'links' => [
            'create' => 'Create a new article',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'sort' => [
                'confirm' => 'Confirm sort',
                'cancel' => 'Cancel sort',
            ],
        ],
    ],

    'panelTitles' => [
        'basicConfiguration' => 'Basic Configuration',
        'content' => 'Content',
        'images' => 'Images',
    ],

    'labels' => [
        'title' => 'Title',
        'slug' => 'Slug',
        'template' => 'Template',
        'publishedAt' => 'Published at',
        'lead' => 'Lead',
        'content' => 'Content',
        'imageMain' => 'Image',
        'imageMainDelete' => 'Delete image',
        'showOnHomePage' => 'Show on home page',
        'save' => [
            'default' => 'Save',
            'loading' => 'Saving...',
        ],
    ],

    'help' => [
        'slug' => 'We recommend leaving this field blank - in that case, the system will automatically generate the slug based on the title.',
        'imageMain' => 'Please upload an image with the dimensions <code>1140×380</code>.',
    ],

    'confirmDelete' => [
        'message' => 'Are you sure you want to delete this article?',
        'confirm' => [
            'default' => 'Confirm',
            'loading' => 'Deleting...',
        ],
        'cancel' => [
            'default' => 'Cancel',
            'loading' => 'Canceling...',
        ],
    ],

    'successMessages' => [
        'create' => 'You have successfully created a new article. You may continue editing this article, or <a href=":createUrl">create a new one</a>.',
        'edit' => 'You have successfully updated this article.',
        'delete' => 'You have successfully deleted the article ":title".',
    ],

];
