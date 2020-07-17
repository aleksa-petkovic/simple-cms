<?php

declare(strict_types=1);

return [

    'module' => 'Users',

    'titles' => [
        'index' => 'Users',
        'create' => 'Create a new user',
        'edit' => 'Edit',
        'delete' => 'Delete',
    ],

    'index' => [
        'links' => [
            'create' => 'Create a new user',
            'resetPassword' => 'Reset password',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'roles' => [
                'all' => 'All users',
                'admins' => 'Administrators',
                'users' => 'Users',
            ],
        ],
    ],

    'panelTitles' => [
        'basicConfiguration' => 'Basic configuration',
    ],

    'labels' => [
        'id' => 'ID',
        'fullName' => 'Full name',
        'firstName' => 'First name',
        'lastName' => 'Last name',
        'imageMain' => 'Image',
        'email' => 'Email',
        'password' => 'Password',
        'role' => 'Role',
        'roles' => 'Roles',
        'sendWelcomeEmail' => 'Send welcome email',
        'save' => [
            'default' => 'Save',
            'loading' => 'Saving...',
        ],
    ],

    'help' => [
        'imageMain' => 'Please upload an image with the dimensions <code>640×640px</code>.',
        'password' => [
            'create' => 'If you leave this field blank, the user\'s password will be automatically generated.',
            'edit' => 'If you don\'t want to change the user\'s password, just leave this field blank.',
        ],
        'neverLoggedInUserWarning' => 'This user has never logged into their account.',
    ],

    'confirmDelete' => [
        'message' => 'Are you sure you want to delete this user?',
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
        'create' => 'You have successfully created a new user. You may continue editing this user, or <a href=":createUrl">create a new one</a>.',
        'edit' => 'You have successfully updated this user.',
        'delete' => 'You have successfully deleted the user ":fullName".',
    ],

];
