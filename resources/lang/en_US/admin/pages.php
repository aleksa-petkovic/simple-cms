<?php

declare(strict_types=1);


return [

    'module' => 'Pages',

    'titles' => [
        'index' => 'Pages',
        'create' => 'Create a new page',
        'edit' => 'Edit',
        'delete' => 'Delete',
    ],

    'index' => [
        'links' => [
            'sort' => [
                'confirm' => 'Confirm sort',
                'cancel' => 'Cancel sort',
            ],
            'create' => 'Create a new page',
            'articles' => 'Articles',
            'edit' => 'Edit',
            'delete' => 'Delete',
        ],
    ],

    'panelTitles' => [
        'basicConfiguration' => 'Basic configuration',
        'advancedOptions' => 'Advanced options',
        'content' => 'Content',
        'images' => 'Images',
    ],

    'labels' => [
        'title' => 'Title',
        'slug' => 'Slug',
        'template' => 'Template',
        'publishedAt' => 'Published at',
        'showInNavigation' => 'Show in navigation',
        'selectableInNavigation' => 'Selectable in navigation',
        'showArticlesInNavigation' => 'Show articles in navigation',
        'articlesPerPage' => 'Articles per page',
        'lead' => 'Lead',
        'content' => 'Content',
        'imageMain' => 'Image',
        'imageMainDelete' => 'Delete image',
        'save' => [
            'default' => 'Save',
            'loading' => 'Saving...',
        ],
    ],

    'help' => [
        'slug' => 'We recommend leaving this field blank - in that case, the system will automatically generate the slug based on the title.',
        'imageMain' => 'Please upload an image with the dimensions <code>1140×380</code>.',
        'articlesPerPage' => 'If you want to disable the pagination for this page, set the value to 0.',
    ],

    'confirmDelete' => [
        'message' => 'Are you sure you want to delete this page? This will also delete all subpages and articles belonging to this page!',
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
        'create' => 'You have successfully created a new page. You may continue editing this page, or <a href=":createUrl">create a new one</a>.',
        'edit' => 'You have successfully updated this page.',
        'delete' => 'You have successfully deleted the page ":title".',
    ],

];
