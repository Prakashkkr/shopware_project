/*
 * @package inventory
 */

import template from './sw-test-demo-list.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('sw-test-demo-list', {
    template,

    inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('listing'),
    ],

    data() {
        return {
            testdemos: null,
            isLoading: true,
            sortBy: 'name',
            sortDirection: 'ASC',
            total: 0,
            searchConfigEntity: 'test_demo',
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(),
        };
    },

    computed: {
        testdemoRepository() {
            return this.repositoryFactory.create('test_demo');
        },

        testdemoColumns() {
            return [{
                property: 'name',
                dataIndex: 'name',
                label: 'sw-test-demo.list.columnName',
                inlineEdit: 'string',
            },
                {
                property: 'city',
                allowResize: true,
                routerLink: 'sw.test.demo.detail',
                label: 'sw-test-demo.list.columnCity',
                inlineEdit: 'string',
            }, {
                property: 'countryState.name',
                routerLink: 'sw.test.demo.detail',
                label: 'sw-test-demo.list.columnCountryStateId',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'country.name',
                routerLink: 'sw.test.demo.detail',
                label: 'sw-test-demo.list.columnCountryId',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'active',
                label: 'sw-test-demo.list.columnActive',
                inlineEdit: 'boolean',
                allowResize: true,
                align: 'center',
                },{
                property: 'product.name',
                routerLink: 'sw.test.demo.detail',
                label: 'sw-test-demo.list.columnProductId',
                inlineEdit: 'string',
                primary: true,
                }];
        },

        testdemoCriteria() {
            const testdemoCriteria = new Criteria(this.page, this.limit);
            testdemoCriteria.addAssociation('countryState');
            testdemoCriteria.addAssociation('country');
            // testdemoCriteria.addAssociation('product');
            testdemoCriteria.setTerm(this.term);
            testdemoCriteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection, this.naturalSorting));

            return testdemoCriteria;
        },
    },

    methods: {
        onChangeLanguage(languageId) {
            this.getList(languageId);
        },

        async getList() {
            this.isLoading = true;

            const criteria = await this.addQueryScores(this.term, this.testdemoCriteria);

            if (!this.entitySearchable) {
                this.isLoading = false;
                this.total = 0;

                return false;
            }

            if (this.freshSearchTerm) {
                criteria.resetSorting();
            }

            return this.testdemoRepository.search(criteria)
                .then(searchResult => {
                    this.testdemos = searchResult;
                    this.total = searchResult.total;
                    this.isLoading = false;
                });
        },

        updateTotal({ total }) {
            this.total = total;
        },
    },
});
