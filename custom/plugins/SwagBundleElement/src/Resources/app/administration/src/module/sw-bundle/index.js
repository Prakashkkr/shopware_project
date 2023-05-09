import './page/sw-bundle-list';
import './page/sw-bundle-detail';
import './acl';
import './snippet/en-GB.json';
const { Module } = Shopware;

Module.register('sw-bundle', {
    type: 'core',
    name: 'bundle',
    title: 'sw.bundle.general.mainMenuItemGeneral',
    description: 'Manages the bundle of the application',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#57D9A3',
    icon: 'regular-products',
    favicon: 'icon-module-products.png',
    entity: 'bundle',

    routes: {
        index: {
            components: {
                default: 'sw-bundle-list',
            },
            path: 'index',
            meta: {
                privilege: 'bundle.viewer',
            },
        },
        create: {
            component: 'sw-bundle-detail',
            path: 'create',
            meta: {
                parentPath: 'sw.bundle.index',
                privilege: 'bundle.creator',
            },
        },
        detail: {
            component: 'sw-bundle-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'sw.bundle.index',
                privilege: 'bundle.viewer',
            },
            props: {
                default(route) {
                    return {
                        bundleId: route.params.id,
                    };
                },
            },
        },
    },

    navigation: [{
        path: 'sw.bundle.index',
        privilege: 'bundle.viewer',
        label: 'sw-bundle.general.mainMenuItemList',
        id: 'sw-bundle',
        parent: 'sw-catalogue',
        color: '#57D9A3',
        position: 50,
    }],

});
