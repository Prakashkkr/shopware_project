/*
 * @package inventory
 */

Shopware.Service('privileges')
    .addPrivilegeMappingEntry({
        category: 'permissions',
        parent: 'catalogues',
        key: 'test_demo',
        roles: {
            viewer: {
                privileges: [
                    'test_demo:read',
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
                    'test_demo:update',
                    Shopware.Service('privileges').getPrivileges('media.creator'),
                ],
                dependencies: [
                    'test_demo.viewer',
                ],
            },
            creator: {
                privileges: [
                    'test_demo:create',
                ],
                dependencies: [
                    'test_demo.viewer',
                    'test_demo.editor',
                ],
            },
            deleter: {
                privileges: [
                    'test_demo:delete',
                ],
                dependencies: [
                    'test_demo.viewer',
                ],
            },
        },
    });
