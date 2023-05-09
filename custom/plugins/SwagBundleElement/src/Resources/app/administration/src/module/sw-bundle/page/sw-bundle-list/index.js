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
            },{
                property: 'Author',
                dataIndex: 'author',
                allowResize: true,
                label: 'sw-bundle.list.columnAuthor',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'release_date',
                dataIndex: 'release_date',
                allowResize: true,
                label: 'sw-bundle.list.columnRelease_date',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'bundleCategory.name',
                label: 'sw-bundle.list.columnbundleCategoryId',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'active',
                label: 'sw-bundle.list.columnActive',
                inlineEdit: 'boolean',
                allowResize: true,
                align: 'center',
            }];
        },

        // bundleCategoryCriteria() {
        //     const bundleCategoryCriteria = new Criteria(this.page, this.limit);
        //     bundleCategoryCriteria.addAssociation('bundleCategory');
        //     bundleCategoryCriteria.setTerm(this.term);
        //     bundleCategoryCriteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection, this.naturalSorting));
        //     return bundleCategoryCriteria;
        // },
    },

    methods: {
        onChangeLanguage(languageId) {
            this.getList(languageId);
        },

        async getList() {
            this.isLoading = true;

            const criteria = await this.addQueryScores(this.term, this.bundleCategoryCriteria);

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
