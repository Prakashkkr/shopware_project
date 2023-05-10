import './page/sw-bundle-element-list';
import './page/sw-bundle-element-detail';
import './acl';
import './snippet/en-GB.json';
const { Module } = Shopware;

Module.register('sw-bundle-element', {
    type: 'core',
    name: 'bundleElement',
    title: 'sw.bundle.element.general.mainMenuItemGeneral',
    description: 'Manages the bundleElement of the application',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#57D9A3',
    icon: 'regular-products',
    favicon: 'icon-module-products.png',
    entity: 'bundle_element',

    routes: {
        index: {
            components: {
                default: 'sw-bundle-element-list',
            },
            path: 'index',
            meta: {
                privilege: 'bundle_element.viewer',
            },
        },
        create: {
            component: 'sw-bundle-element-detail',
            path: 'create',
            meta: {
                parentPath: 'sw.bundle.element.index',
                privilege: 'bundle_element.creator',
            },
        },
        detail: {
            component: 'sw-bundle-element-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'sw.bundle.element.index',
                privilege: 'bundle_element.viewer',
            },
            props: {
                default(route) {
                    return {
                        bundleElementId: route.params.id,
                    };
                },
            },
        },
    },

    navigation: [{
        path: 'sw.bundle.element.index',
        privilege: 'bundle_element.viewer',
        label: 'sw-bundle-element.general.mainMenuItemList',
        id: 'sw-bundle-element',
        parent: 'sw-catalogue',
        color: '#57D9A3',
        position: 50,
    }],

});
