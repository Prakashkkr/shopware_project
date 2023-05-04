import template from './sw-blog-list.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('sw-blog-list', {
    template,

    inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('listing'),
    ],

    data() {
        return {
            blogs: null,
            isLoading: true,
            sortBy: 'name',
            sortDirection: 'ASC',
            total: 0,
            searchConfigEntity: 'blog_finder',
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(),
        };
    },

    computed: {
        blogRepository() {
            return this.repositoryFactory.create('blog_finder');
        },

        blogColumns() {
            return [{
                property: 'name',
                dataIndex: 'name',
                allowResize: true,
                routerLink: 'sw.blog.detail',
                label: 'sw-blog.list.columnName',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'description',
                dataIndex: 'description',
                allowResize: true,
                label: 'sw-blog.list.columnDescription',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'Author',
                dataIndex: 'author',
                allowResize: true,
                label: 'sw-blog.list.columnAuthor',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'release_date',
                dataIndex: 'release_date',
                allowResize: true,
                label: 'sw-blog.list.columnRelease_date',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'blogCategory.name',
                label: 'sw-blog.list.columnBlogCategoryId',
                inlineEdit: 'string',
                primary: true,
            },{
                property: 'active',
                label: 'sw-blog.list.columnActive',
                inlineEdit: 'boolean',
                allowResize: true,
                align: 'center',
            }];
        },

        blogCategoryCriteria() {
            const blogCategoryCriteria = new Criteria(this.page, this.limit);
            blogCategoryCriteria.addAssociation('blogCategory');
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

            return this.blogRepository.search(criteria)
                .then(searchResult => {
                    this.blogs = searchResult;
                    this.total = searchResult.total;
                    this.isLoading = false;
                });
        },

        updateTotal({ total }) {
            this.total = total;
        },
    },
});
