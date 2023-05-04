import './component';
import './preview';

/**
 * @private since v6.5.0
 * @package content
 */
Shopware.Service('cmsService').registerCmsBlock({
    name: 'blog-text',
    label: 'sw-cms.blocks.blogText.label',
    category: 'text',
    component: 'sw-cms-block-blog-text',
    previewComponent: 'sw-cms-preview-blog-text',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed',
    },
    slots: {
        content: 'blog-text',
    },
});
