import './page/sw-test-demo-list';
import './page/sw-test-demo-detail';
import './acl';
import './snippet/en-GB.json';
const { Module } = Shopware;

Module.register('sw-test-demo', {
    type: 'core',
    name: 'testdemo',
    title: 'sw-test-demo.general.mainMenuItemGeneral',
    description: 'Manages the testdemo of the application',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#57D9A3',
    icon: 'regular-products',
    favicon: 'icon-module-products.png',
    entity: 'test_demo',

    routes: {
        index: {
            components: {
                default: 'sw-test-demo-list',
            },
            path: 'index',
            meta: {
                privilege: 'test_demo.viewer',
            },
        },
        create: {
            component: 'sw-test-demo-detail',
            path: 'create',
            meta: {
                parentPath: 'sw.test-demo.index',
                privilege: 'test_demo.creator',
            },
        },
        detail: {
            component: 'sw-test-demo-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'sw.test.demo.index',
                privilege: 'test_demo.viewer',
            },
            props: {
                default(route) {
                    return {
                        testdemoId: route.params.id,
                    };
                },
            },
        },
    },

    navigation: [{
        path: 'sw.test.demo.index',
        privilege: 'test_demo.viewer',
        label: 'sw-test-demo.general.mainMenuItemList',
        id: 'sw-test-demo',
        parent: 'sw-catalogue',
        color: '#57D9A3',
        position: 50,
    }],

});
