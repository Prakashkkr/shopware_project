import './component';
import './config';
import './preview';

Shopware.Service('cmsService').registerCmsElement({
    name: 'blog-image',
    label: 'sw-cms.elements.blogImages.label',
    component: 'sw-cms-el-blog-image',
    configComponent: 'sw-cms-el-config-blog-image',
    previewComponent: 'sw-cms-el-preview-blog-image',
    defaultConfig: {
        media: {
            source: 'static',
            value: null,
            required: true,
            entity: {
                name: 'media',
            },
        },
        displayMode: {
            source: 'static',
            value: 'standard',
        },
        url: {
            source: 'static',
            value: null,
        },
        newTab: {
            source: 'static',
            value: false,
        },
        minHeight: {
            source: 'static',
            value: '340px',
        },
        verticalAlign: {
            source: 'static',
            value: null,
        },
    },
});
