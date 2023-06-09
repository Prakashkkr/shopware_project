import CMS from '../../../constant/sw-cms.constant';
import './component';
import './preview';

/**
 * @private since v6.5.0
 * @package content
 */
Shopware.Service('cmsService').registerCmsBlock({
    name: 'image-text-cover',
    label: 'sw-cms.blocks.textImage.imageTextCover.label',
    category: 'text-image',
    component: 'sw-cms-block-image-text-cover',
    previewComponent: 'sw-cms-preview-image-text-cover',
    defaultConfig: {
        marginBottom: null,
        marginTop: null,
        marginLeft: null,
        marginRight: null,
        sizingMode: 'full_width',
    },
    slots: {
        left: {
            type: 'image',
            default: {
                config: {
                    displayMode: { source: 'static', value: 'cover' },
                },
                data: {
                    media: {
                        value: CMS.MEDIA.previewMountain,
                        source: 'default',
                    },
                },
            },
        },
        right: 'text',
    },
});
