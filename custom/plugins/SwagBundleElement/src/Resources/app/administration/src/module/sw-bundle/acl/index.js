Shopware.Service('privileges')
    .addPrivilegeMappingEntry({
        category: 'permissions',
        parent: 'catalogues',
        key: 'bundle',
        roles: {
            viewer: {
                privileges: [
                    'bundle:read',
                    'custom_field_set:read',
                    'custom_field:read',
                    'custom_field_set_relation:read',
                    Shopware.Service('privileges').getPrivileges('media.viewer'),
                    'user_config:read',
                    'user_config:create',
                    'user_config:update',
                ],
                dependencies: [],
            },
            editor: {
                privileges: [
                    'bundle:update',
                    Shopware.Service('privileges').getPrivileges('media.creator'),
                ],
                dependencies: [
                    'bundle.viewer',
                ],
            },
            creator: {
                privileges: [
                    'bundle:create',
                ],
                dependencies: [
                    'bundle.viewer',
                    'bundle.editor',
                ],
            },
            deleter: {
                privileges: [
                    'bundle:delete',
                ],
                dependencies: [
                    'bundle.viewer',
                ],
            },
        },
    });
