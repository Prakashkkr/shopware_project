import './component';
import './preview'

Shopware.Service('cmsService').registerCmsBlock({
    name: 'blog-video',
    label: 'sw-cms.blocks.blogVideo.label',
    category: 'video',
    component: 'sw-cms-block-blog-video',
    previewComponent: 'sw-cms-preview-blog-video',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed',
    },
    slots: {
        video: 'blog-video',
    },
});