import template from './sw-cms-el-preview-blog-text.html.twig';
import './sw-cms-el-preview-blog-text.scss';

const { Component } = Shopware;

/**
 * @private since v6.5.0
 * @package content
 */
Component.register('sw-cms-el-preview-blog-text', {
    template,
});
