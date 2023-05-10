import template from './sw-bundle-element-list.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('sw-bundle-element-list', {
    template,

    inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('listing'),
    ],

    data() {
        return {
            bundleElement: null,
            isLoading: true,
            sortBy: 'name',
            sortDirection: 'ASC',
            total: 0,
            searchConfigEntity: 'bundle_element',
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(),
        };
    },

    computed: {
        bundleElementRepository() {
            return this.repositoryFactory.create('bundle_element');
        },

        bundleElementColumns() {
            return [{
                property: 'position',
                dataIndex: 'position',
                allowResize: true,
                label: 'sw-bundle-element.list.columnPosition',
                inlineEdit: 'string',
                primary: true,
                 },{
                property: 'Discount_type',
                dataIndex: 'Discount_type',
                allowResize: true,
                label: 'sw-bundle-element.list.columnDiscount_type',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'Discount',
                dataIndex: 'Discount',
                allowResize: true,
                label: 'sw-bundle-element.list.columnDiscount',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'Quantity',
                dataIndex: 'Quantity',
                allowResize: true,
                label: 'sw-bundle-element.list.columnQuantity',
                inlineEdit: 'string',
                primary: true,

            }];
        },

        bundleElementCriteria() {
            const bundleElementCriteria = new Criteria(this.page, this.limit);
            bundleElementCriteria.setTerm(this.term);
            bundleElementCriteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection, this.naturalSorting));
            return bundleElementCriteria;
        },
    },

    methods: {
        onChangeLanguage(languageId) {
            this.getList(languageId);
        },

        async getList() {
            this.isLoading = true;

            const criteria = await this.addQueryScores(this.term, this.bundleElementCriteria);

            if (!this.entitySearchable) {
                this.isLoading = false;
                this.total = 0;

                return false;
            }

            if (this.freshSearchTerm) {
                criteria.resetSorting();
            }

            return this.bundleElementRepository.search(criteria)
                .then(searchResult => {
                    this.bundleElement = searchResult;
                    this.total = searchResult.total;
                    this.isLoading = false;
                });
        },

        updateTotal({ total }) {
            this.total = total;
        },
    },
});
