import template from './sw-bundle-element-detail.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria, Context } = Shopware.Data;

Component.register('sw-bundle-element-detail', {
    template,

    inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('placeholder'),
        Mixin.getByName('notification'),
        Mixin.getByName('discard-detail-page-changes')('bundleElement'),
    ],

    shortcuts: {
        'SYSTEMKEY+S': 'onSave',
        ESCAPE: 'onCancel',
    },

    props: {

        bundleElementId: {
            type: String,
            required: false,
            default: null,
        },
    },


    data() {
        return {
            bundleElement: null,
            customFieldSets: [],
            isLoading: false,
            isSaveSuccessful: false,
            billingProducts:null,
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(this.identifier),
        };
    },

    computed: {
        identifier() {
            return this.placeholder(this.bundleElement, 'name');
        },
        productCriteria() {
            const criteria = new Criteria(1, 25);
            return criteria;
        },
        bundleCriteria() {
            const criteria = new Criteria(1, 25);
            return criteria;
        },

        bundleElementIsLoading() {
            return this.isLoading || this.bundleElement == null;
        },

        bundleElementRepository() {
            return this.repositoryFactory.create('bundle_element');
        },

        customFieldSetRepository() {
            return this.repositoryFactory.create('custom_field_set');
        },

        customFieldSetCriteria() {
            const criteria = new Criteria(1, null);
            criteria.addFilter(
                Criteria.equals('relations.entityName', 'bundle_element'),
            );

            return criteria;
        },

        tooltipSave() {
            if (this.acl.can('bundle_element.editor')) {
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
    },

    watch: {
        bundleElementId() {
            this.createdComponent();
        },
        // 'bundleElement.discount_type'(value, oldValue) {
        //     if (oldValue === 'percentage') {
        //         this.bundleElement.maxValue = null;
        //     }
        //     if (value === 'free') {
        //         this.bundleElement.applierKey = 'SELECT';
        //         this.bundleElement.value = 100;
        //
        //         return;
        //     }
        //
        //     if (value === 'absolute') {
        //         this.bundleElement.applierKey = 'SELECT';
        //         this.bundleElement.usageKey = 'ALL';
        //     } else if (value === 'percentage') {
        //         this.bundleElement.value = Math.min(this.bundleElement.value, 100);
        //     }
        // },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {

            Shopware.ExtensionAPI.publishData({
                id: 'sw-bundle-element-detail__bundleElement',
                path: 'bundleElement',
                scope: this,
            });
            if (this.bundleElementId) {
                this.loadEntityData();
                return;
            }

            // let config = {
            //     type: this.bundleElement.type || this.preselectedDiscountType,
            //     applierKey: this.discount.applierKey || this.preselectedApplyDiscountTo,
            // };

            // if (this.discountScope === 'basic') {
            //     config = {
            //         ...config,
            //         scope: 'cart',
            //     };
            // } else if (this.discountScope === 'buy-x-get-y') {
            //     config = {
            //         ...config,
            //         scope: 'set',
            //     };
            // } else if (this.discountScope === 'shipping-discount') {
            //     config = {
            //         ...config,
            //         scope: 'delivery',
            //     };
            // }

            // Object.assign(this.bundleElement, config);

            Shopware.State.commit('context/resetLanguageToDefault');
            this.bundleElement = this.bundleElementRepository.create();
        },

        async loadEntityData() {
            const [bundleElementResponse, customFieldResponse] = await Promise.allSettled([
                this.bundleElementRepository.get(this.bundleElementId),
                this.customFieldSetRepository.search(this.customFieldSetCriteria),
            ]);

            if (bundleElementResponse.status === 'fulfilled') {
                this.bundleElement = bundleElementResponse.value;
            }

            if (customFieldResponse.status === 'fulfilled') {
                this.customFieldSets = customFieldResponse.value;
            }

            if (bundleElementResponse.status === 'rejected' || customFieldResponse.status === 'rejected') {
                this.createNotificationError({
                    message: this.$tc(
                        'global.notification.notificationLoadingDataErrorMessage',
                    ),
                });
            }

            this.isLoading = false;
        },


        getDiscountTypeSelection() {
            const prefix = 'sw-bundle_element.detail.discounts.settings.discountType.discountTypeSelection';
            return [{
                value: 'percentage',
                display: this.$tc(`${prefix}.displayPercentage`),
            }, {
                value: (this.discount.scope === 'delivery' ? 'absolute' : 'fixed'),
                display: this.$tc(`${prefix}.displayFixedDiscount`),
            }, {
                value: 'fixed_unit',
                display: this.$tc(`${prefix}.displayFixedPrice`),
            }, {
                value: 'free',
                display: this.$tc(`${prefix}.displayFree`),
            }];
        },

        abortOnLanguageChange() {
            return this.bundleElementRepository.hasChanges(this.bundleElement);
        },

        saveOnLanguageChange() {
            return this.onSave();
        },

        onChangeLanguage() {
            this.loadEntityData();
        },

        onSave() {
            if (!this.acl.can('bundle_element.editor')) {
                return;
            }

            this.isLoading = true;
            this.bundleElementRepository.save(this.bundleElement).then(() => {
                this.isLoading = false;
                this.isSaveSuccessful = true;
                if (this.bundleElementId === null) {
                    this.$router.push({ name: 'sw.bundle.element.list', params: { id: this.bundleElement.id } });
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
        updateItemQuantity(item) {
            if (item.type !== this.lineItemTypes.CUSTOM) {
                return;
            }

            // item.priceDefinition.quantity = item.quantity;
        },

        onCancel() {
            this.$router.push({ name: 'sw.bundle.element.index' });
        },
    },
});
