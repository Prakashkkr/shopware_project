import template from './sw-order-create-invalid-promotion-modal.html.twig';
import './sw-order-create-invalid-promotion-modal.scss';

/**
 * @package customer-order
 */

const { Component, State } = Shopware;

// eslint-disable-next-line sw-deprecation-rules/private-feature-declarations
Component.register('sw-order-create-invalid-promotion-modal', {
    template,

    computed: {
        invalidPromotionCodes() {
            return State.getters['swOrder/invalidPromotionCodes'];
        },
    },

    methods: {
        onClose() {
            this.$emit('close');
        },

        onConfirm() {
            this.$emit('confirm');
        },
    },
});
