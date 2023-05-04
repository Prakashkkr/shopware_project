import './page/sw-blog-category-list';
import './page/sw-blog-category-detail';
import './acl';
import './snippet/en-GB.json';
const { Module } = Shopware;

Module.register('sw-blog-category', {
    type: 'core',
    name: 'blogCategory',
    title: 'sw-blog-category.general.mainMenuItemGeneral',
    description: 'Manages the blogCategory of the application',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#57D9A3',
    icon: 'regular-products',
    favicon: 'icon-module-products.png',
    entity: 'blog_category',

    routes: {
        index: {
            components: {
                default: 'sw-blog-category-list',
            },
            path: 'index',
            meta: {
                privilege: 'blog_category.viewer',
            },
        },
        create: {
            component: 'sw-blog-category-detail',
            path: 'create',
            meta: {
                parentPath: 'sw.blog.category.index',
                privilege: 'blog_category.creator',
            },
        },
        detail: {
            component: 'sw-blog-category-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'sw.blog.category.index',
                privilege: 'blog_category.viewer',
            },
            props: {
                default(route) {
                    return {
                        blogCategoryId: route.params.id,
                    };
                },
            },
        },
    },

    navigation: [{
        path: 'sw.blog.category.index',
        privilege: 'blog_category.viewer',
        label: 'sw-blog-category.general.mainMenuItemList',
        id: 'sw-blog-category',
        parent: 'sw-catalogue',
        color: '#57D9A3',
        position: 50,
    }],

});
