import template from './sw-bundle-detail.html.twig';

const { Component, Mixin } = Shopware;
const { EntityCollection, Criteria, Context } = Shopware.Data;
const { mapPropertyErrors } = Component.getComponentHelper();

Component.register('sw-bundle-detail', {
    template,

    inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('placeholder'),
        Mixin.getByName('notification'),
        Mixin.getByName('discard-detail-page-changes')('bundle'),
    ],

    shortcuts: {
        'SYSTEMKEY+S': 'onSave',
        ESCAPE: 'onCancel',
    },

    props: {
        bundleId: {
            type: String,
            required: false,
            default: null,
        },
    },


    data() {
        return {
            bundle: null,
            customFieldSets: [],
            isLoading: false,
            isSaveSuccessful: false,
            billingProducts:null,
            inputKey: 'productIds',
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(this.identifier),
        };
    },

    computed: {
        identifier() {
            return this.placeholder(this.bundle, 'name');
        },
        productRepository() {
            return this.repositoryFactory.create('product');
        },
        productIds: {
            get() {
                return this.bundle.products || [];
            },
            set(productIds) {
                this.bundle.value = { ...this.bundle.products, productIds };
            },
        },

        bundleIsLoading() {
            return this.isLoading || this.bundle == null;
        },

        bundleRepository() {
            return this.repositoryFactory.create('bundle');
        },
        productCriteria() {
            const criteria = new Criteria(1, 25);
            return criteria;
        },

        customFieldSetRepository() {
            return this.repositoryFactory.create('custom_field_set');
        },

        customFieldSetCriteria() {
            const criteria = new Criteria(1, null);
            criteria.addFilter(
                Criteria.equals('relations.entityName', 'bundle_finder'),
            );

            return criteria;
        },

        tooltipSave() {
            if (this.acl.can('bundle_finder.editor')) {
                const systemKey = this.$device.getSystemKey();

                return {
                    message: `${systemKey} + S`,
                    appearance: 'light',
                };
            }

            return {
                showDelay: 300,
                message: this.$tc('sw-privileges.tooltip.warning'),
                disabled: this.acl.can('order.editor'),
                showOnDisabledElements: true,
            };
        },

        tooltipCancel() {
            return {
                message: 'ESC',
                appearance: 'light',
            };
        },
        ...mapPropertyErrors('bundle', ['name']),
    },

    watch: {
        bundleId() {
            this.createdComponent();
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {

            this.billingProducts = new EntityCollection(
                this.productRepository.route,
                this.productRepository.entityName,
                // Context.api,
            );

            Shopware.ExtensionAPI.publishData({
                id: 'sw-bundle-detail__bundle',
                path: 'bundle',
                scope: this,
            });
            if (this.bundleId) {
                this.loadEntityData();
                return;
            }

            Shopware.State.commit('context/resetLanguageToDefault');
            this.bundle = this.bundleRepository.create();

        },
        setProductIds(products) {
            this.productIds = products.getIds();
            this.billingProducts = products;
            this.bundle.products = products;
        },

        async loadEntityData() {
            this.isLoading = true;
            const bundleCriteria = new Criteria();
            bundleCriteria.addFilter(Criteria.equals('id',this.bundleId))
            bundleCriteria.addAssociation('products');

            this.bundleRepository.search(bundleCriteria).then((res) =>{
                this.bundle =res[0];
                this.billingProducts = this.bundle.products;
            }).catch((exception) => {
                this.isLoading = false;
                this.createNotificationError({
                    message: this.$tc(
                        'global.notification.notificationSaveErrorMessageRequiredFieldsInvalid',
                    ),
                });
                throw exception;
            });


            const [bundleResponse, customFieldResponse] = await Promise.allSettled([
                this.bundleRepository.get(this.bundleId),
                this.customFieldSetRepository.search(this.customFieldSetCriteria),
            ]);

            if (bundleResponse.status === 'fulfilled') {
                this.bundle = bundleResponse.value;
            }

            if (customFieldResponse.status === 'fulfilled') {
                this.customFieldSets = customFieldResponse.value;
            }

            if (bundleResponse.status === 'rejected' || customFieldResponse.status === 'rejected') {
                this.createNotificationError({
                    message: this.$tc(
                        'global.notification.notificationLoadingDataErrorMessage',
                    ),
                });
            }

            this.isLoading = false;
        },

        abortOnLanguageChange() {
            return this.bundleRepository.hasChanges(this.bundle);
        },

        saveOnLanguageChange() {
            return this.onSave();
        },

        onChangeLanguage() {
            this.loadEntityData();
        },

        onSave() {
            if (!this.acl.can('bundle_finder.editor')) {
                return;
            }

            this.isLoading = true;
            this.bundleRepository.save(this.bundle).then(() => {
                this.isLoading = false;
                this.isSaveSuccessful = true;
                if (this.bundleId === null) {
                    this.$router.push({ name: 'sw.bundle.list', params: { id: this.bundle.id } });
                    return;
                }

                this.loadEntityData();
            }).catch((exception) => {
                this.isLoading = false;
                this.createNotificationError({
                    message: this.$tc(
                        'global.notification.notificationSaveErrorMessageRequiredFieldsInvalid',
                    ),
                });
                throw exception;
            });
        },

        onCancel() {
            this.$router.push({ name: 'sw.bundle.index' });
        },
    },
});
