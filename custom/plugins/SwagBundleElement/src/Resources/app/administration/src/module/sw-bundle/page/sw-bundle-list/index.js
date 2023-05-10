import template from './sw-bundle-list.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('sw-bundle-list', {
    template,

    inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('listing'),
    ],

    data() {
        return {
            bundles: null,
            isLoading: true,
            sortBy: 'name',
            sortDirection: 'ASC',
            total: 0,
            searchConfigEntity: 'bundle',
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(),
        };
    },

    computed: {
        bundleRepository() {
            return this.repositoryFactory.create('bundle');
        },

        bundleColumns() {
            return [{
                property: 'name',
                dataIndex: 'name',
                allowResize: true,
                routerLink: 'sw.bundle.detail',
                label: 'sw-bundle.list.columnName',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'description',
                dataIndex: 'description',
                allowResize: true,
                label: 'sw-bundle.list.columnDescription',
                inlineEdit: 'string',
                primary: true,
            },
                {
                property: 'headline',
                dataIndex: 'headline',
                allowResize: true,
                label: 'sw-bundle.list.columnHeadline',
                inlineEdit: 'string',
                primary: true,
                 },
                {
                property: 'position',
                dataIndex: 'position',
                allowResize: true,
                label: 'sw-bundle.list.columnPosition',
                inlineEdit: 'string',
                primary: true,
                 },
                {
                property: 'active',
                label: 'sw-bundle.list.columnActive',
                inlineEdit: 'boolean',
                allowResize: true,
                align: 'center',
            }];
        },

        bundleCriteria() {
            const bundleCriteria = new Criteria(this.page, this.limit);
            bundleCriteria.setTerm(this.term);
            bundleCriteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection, this.naturalSorting));
            return bundleCriteria;
        },
    },

    methods: {
        onChangeLanguage(languageId) {
            this.getList(languageId);
        },

        async getList() {
            this.isLoading = true;

            const criteria = await this.addQueryScores(this.term, this.bundleCriteria);

            if (!this.entitySearchable) {
                this.isLoading = false;
                this.total = 0;

                return false;
            }

            if (this.freshSearchTerm) {
                criteria.resetSorting();
            }

            return this.bundleRepository.search(criteria)
                .then(searchResult => {
                    this.bundles = searchResult;
                    this.total = searchResult.total;
                    this.isLoading = false;
                });
        },

        updateTotal({ total }) {
            this.total = total;
        },
    },
});
