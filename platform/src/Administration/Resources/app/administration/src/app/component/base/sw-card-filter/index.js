/**
 * @package admin
 */

import template from './sw-card-filter.html.twig';
import './sw-card-filter.scss';

const { Component, Feature } = Shopware;

// eslint-disable-next-line sw-deprecation-rules/private-feature-declarations
Component.register('sw-card-filter', {
    template,

    props: {
        placeholder: {
            type: String,
            required: false,
            default: '',
        },

        delay: {
            type: Number,
            required: false,
            default: 500,
        },

        initialSearchTerm: {
            type: String,
            required: false,
            default: '',
        },
    },

    data() {
        return {
            term: '',
        };
    },

    computed: {
        hasFilter() {
            return !!this.$slots.filter;
        },

        hasFilterClass() {
            const classCollection = ['sw-card-filter-container'];
            if (this.hasFilter) {
                classCollection.push('hasFilter');
            }

            return classCollection.join(' ');
        },
    },

    watch: {
        /* @deprecated tag:v6.5.0 switch to `@onSearchTermChange` function to use sw-simple-search-field debounce */
        term() {
            if (!Feature.isActive('FEATURE_NEXT_16271')) {
                this.$emit('sw-card-filter-term-change', this.term);
            }
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.term = `${this.initialSearchTerm}`;
        },

        onSearchTermChange() {
            if (Feature.isActive('FEATURE_NEXT_16271')) {
                this.$emit('sw-card-filter-term-change', this.term);
            }
        },
    },
});
