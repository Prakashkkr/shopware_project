import template from './sw-blog-category-list.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('sw-blog-category-list', {
    template,

    inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('listing'),
    ],

    data() {
        return {
            blogCategorys: null,
            isLoading: true,
            sortBy: 'name',
            sortDirection: 'ASC',
            total: 0,
            searchConfigEntity: 'blog_category',
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(),
        };
    },

    computed: {
        blogCategoryRepository() {
            return this.repositoryFactory.create('blog_category');
        },

        blogCategoryColumns() {
            return [{
                property: 'name',
                dataIndex: 'name',
                label: 'sw-blog-category.list.columnName',
                inlineEdit: 'string',
            }];
        },

        blogCategoryCriteria() {
            const blogCategoryCriteria = new Criteria(this.page, this.limit);

            blogCategoryCriteria.setTerm(this.term);
            blogCategoryCriteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection, this.naturalSorting));

            return blogCategoryCriteria;
        },
    },

    methods: {
        onChangeLanguage(languageId) {
            this.getList(languageId);
        },

        async getList() {
            this.isLoading = true;

            const criteria = await this.addQueryScores(this.term, this.blogCategoryCriteria);

            if (!this.entitySearchable) {
                this.isLoading = false;
                this.total = 0;

                return false;
            }

            if (this.freshSearchTerm) {
                criteria.resetSorting();
            }

            return this.blogCategoryRepository.search(criteria)
                .then(searchResult => {
                    this.blogCategorys = searchResult;
                    this.total = searchResult.total;
                    this.isLoading = false;
                });
        },

        updateTotal({ total }) {
            this.total = total;
        },
    },
});
