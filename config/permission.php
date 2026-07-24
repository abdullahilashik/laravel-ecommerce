<?php

return [

    'models' => [

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * Eloquent Model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent Model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know what
         * database tables should be used to retrieve your roles and permissions.
         */

        'roles' => 'roles',

        'permissions' => 'permissions',

        'model_has_permissions' => 'model_has_permissions',

        'model_has_roles' => 'model_has_roles',

        'role_has_permissions' => 'role_has_permissions',

    ],

    'column_names' => [

        /*
         * Change this if you want to name the related IDs other than defaults.
         *
         * e.g. role_id instead of role_id
         */

        'role_pivot_key' => null,

        /*
         * Change this if you want to name the related IDs other than defaults.
         *
         * e.g. permission_id instead of permission_id
         */

        'permission_pivot_key' => null,

        /*
         * Change this if you want to name the model ID other than the default.
         *
         * e.g. model_id instead of model_id
         */

        'model_morph_key' => 'model_id',

        /*
         * Change this if you want to use teams/teams can be used by setting this to true
         * and adding team_id field to the migration.
         * (If team_id is used, then it's a composite key with team_id + role_id + model_id)
         */

        'team_foreign_key' => 'team_id',

    ],

    /*
     * When set to true, the method for checking permissions will be registered on the gate.
     * If you want to use custom permission checking, set this to false.
     */

    'register_permission_check_method' => true,

    /*
     * When set to true, the required cache permissions will be reset when a model
     * is saved or deleted.
     */

    'register_octane_reset_listener' => false,

    /*
     * Teams feature.
     */

    'teams' => false,

    /*
     * Passport client credentials grant support.
     */

    'use_passport_client_credentials' => false,

    /*
     * When set to true, the model permissions and roles cache will be cleared
     * automatically when roles or permissions are assigned or revoked.
     */

    'display_permission_exception' => true,

    'display_role_exception' => true,

    'enable_wildcard_permission' => false,

    'cache' => [

        /*
         * By default all permissions are cached for 24 hours to speed up performance.
         * When permissions or roles are updated the cache is flushed automatically.
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        'key' => 'spatie.permission.cache',

        'store' => 'default',

    ],
];
