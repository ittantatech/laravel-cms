<?php

/**
 * Permissions that will be added in database from this file
 */

return [
    'permissions' => [
        'dashboard' => [
            'dashboard' => 'Dashboard'
        ],
        'role' => [
            'browse-role' => 'Browse Roles',
            'add-role' => 'Add Role',
            'edit-role' => 'Edit Roles',
            'delete-role' => 'Delete Roles',
        ],
        'admin' => [
            'browse-admin' => 'Browse Admin',
            'add-admin' => 'Add Admin',
            'edit-admin' => 'Edit Admin',
            'delete-admin' => 'Delete Admin',
        ],
        'users' => [
            'browse-user' => 'Browse User',
            'add-user' => 'Add User',
            'edit-user' => 'Edit User',
            'delete-user' => 'Delete User',
        ],
        'posts' => [
            'browse-post' => 'Browse Post',
            'add-post' => 'Add Post',
            'edit-post' => 'Edit Post',
            'delete-post' => 'Delete Post',
        ]
    ]
];