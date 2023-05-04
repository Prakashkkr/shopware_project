Shopware.Service('privileges')
    .addPrivilegeMappingEntry({
        category: 'permissions',
        parent: 'catalogues',
        key: 'blog_finder',
        roles: {
            viewer: {
                privileges: [
                    'blog_finder:read',
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
                    'blog_finder:update',
                    Shopware.Service('privileges').getPrivileges('media.creator'),
                ],
                dependencies: [
                    'blog_finder.viewer',
                ],
            },
            creator: {
                privileges: [
                    'blog_finder:create',
                ],
                dependencies: [
                    'blog_finder.viewer',
                    'blog_finder.editor',
                ],
            },
            deleter: {
                privileges: [
                    'blog_finder:delete',
                ],
                dependencies: [
                    'blog_finder.viewer',
                ],
            },
        },
    });
