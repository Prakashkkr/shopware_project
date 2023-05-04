import './page/sw-blog-list';
import './page/sw-blog-detail';
import './acl';
import './snippet/en-GB.json';
const { Module } = Shopware;

Module.register('sw-blog', {
    type: 'core',
    name: 'blog',
    title: 'sw-blog.general.mainMenuItemGeneral',
    description: 'Manages the blog of the application',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#57D9A3',
    icon: 'regular-products',
    favicon: 'icon-module-products.png',
    entity: 'blog_finder',

    routes: {
        index: {
            components: {
                default: 'sw-blog-list',
            },
            path: 'index',
            meta: {
                privilege: 'blog_finder.viewer',
            },
        },
        create: {
            component: 'sw-blog-detail',
            path: 'create',
            meta: {
                parentPath: 'sw.blog.index',
                privilege: 'blog_finder.creator',
            },
        },
        detail: {
            component: 'sw-blog-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'sw.blog.index',
                privilege: 'blog_finder.viewer',
            },
            props: {
                default(route) {
                    return {
                        blogId: route.params.id,
                    };
                },
            },
        },
    },

    navigation: [{
        path: 'sw.blog.index',
        privilege: 'blog_finder.viewer',
        label: 'sw-blog.general.mainMenuItemList',
        id: 'sw-blog',
        parent: 'sw-catalogue',
        color: '#57D9A3',
        position: 50,
    }],

});
