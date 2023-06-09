import template from './sw-condition-line-item-taxation.html.twig';

const { Component, Context } = Shopware;
const { mapPropertyErrors } = Component.getComponentHelper();
const { EntityCollection, Criteria } = Shopware.Data;

/**
 * @package business-ops
 * @deprecated tag:v6.5.0 This rule component will be removed. Use sw-condition-generic-line-item instead.
 */
Component.extend('sw-condition-line-item-taxation', 'sw-condition-base-line-item', {
    template,
    inheritAttrs: false,

    inject: ['repositoryFactory'],

    data() {
        return {
            taxes: null,
        };
    },

    computed: {
        taxRepository() {
            return this.repositoryFactory.create('tax');
        },

        operators() {
            return this.conditionDataProviderService.getOperatorSet('multiStore');
        },

        taxIds: {
            get() {
                this.ensureValueExist();
                return this.condition.value.taxIds || [];
            },
            set(taxIds) {
                this.ensureValueExist();
                this.condition.value = { ...this.condition.value, taxIds };
            },
        },

        ...mapPropertyErrors('condition', ['value.operator', 'value.taxIds']),

        currentError() {
            return this.conditionValueOperatorError || this.conditionValueTaxIdsError;
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.taxes = new EntityCollection(
                this.taxRepository.route,
                this.taxRepository.entityName,
                Context.api,
            );

            if (this.taxIds.length <= 0) {
                return Promise.resolve();
            }

            const criteria = new Criteria(1, 25);
            criteria.setIds(this.taxIds);

            return this.taxRepository.search(criteria, Context.api).then((taxes) => {
                this.taxes = taxes;
            });
        },

        setTaxIds(taxes) {
            this.taxIds = taxes.getIds();
            this.taxes = taxes;
        },
    },
});
