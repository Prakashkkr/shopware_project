Shopware.Service('privileges')
    .addPrivilegeMappingEntry({
        category: 'permissions',
        parent: 'catalogues',
        key: 'bundle_element',
        roles: {
            viewer: {
                privileges: [
                    'bundle_element:read',
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
                    'bundle_element:update',
                    Shopware.Service('privileges').getPrivileges('media.creator'),
                ],
                dependencies: [
                    'bundle_element.viewer',
                ],
            },
            creator: {
                privileges: [
                    'bundle_element:create',
                ],
                dependencies: [
                    'bundle_element.viewer',
                    'bundle_element.editor',
                ],
            },
            deleter: {
                privileges: [
                    'bundle_element:delete',
                ],
                dependencies: [
                    'bundle_element.viewer',
                ],
            },
        },
    });
