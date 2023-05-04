import CMS from '../../constant/sw-cms.constant';
import './component';
import './preview';

Shopware.Service('cmsService').registerCmsBlock( {
    name: 'blog-image-text',
    label: 'sw-cms.blocks.blogTextImage.label',
    category: 'text-image',
    component: 'sw-cms-block-blog-image-text',
    previewComponent: 'sw-cms-preview-blog-image-text',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed',
    },
    slots: {
        left: {
            type: 'blog-image',
            default: {
                config: {
                    displayMode: { source: 'static', value: 'standard' },
                },
                data: {
                    media: {
                        value: CMS.MEDIA.previewMountain,
                        source: 'default',
                    },
                },
            },
        },
        right: 'blog-text',
    },
});
