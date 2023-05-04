/*
 * @package inventory
 */

import template from './sw-test-demo-detail.html.twig';

const { Component, Mixin, Data: { Criteria } } = Shopware;

const { mapPropertyErrors } = Shopware.Component.getComponentHelper();

Component.register('sw-test-demo-detail', {
    template,

    inject: ['repositoryFactory', 'acl'],

    mixins: [
        Mixin.getByName('placeholder'),
        Mixin.getByName('notification'),
        Mixin.getByName('discard-detail-page-changes')('testdemo'),
    ],

    shortcuts: {
        'SYSTEMKEY+S': 'onSave',
        ESCAPE: 'onCancel',
    },

    props: {
        testdemoId: {
            type: String,
            required: false,
            default: null,
        },
    },


    data() {
        return {
            testdemo: null,
            customFieldSets: [],
            isLoading: false,
            isSaveSuccessful: false,
            country: null,
            states: [],
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle(this.identifier),
        };
    },

    computed: {
        identifier() {
            return this.placeholder(this.testdemo, 'name');
        },

        testdemoIsLoading() {
            return this.isLoading || this.testdemo == null;
        },
        countryCriteria() {
            const criteria = new Criteria(1, 25);
            criteria.addSorting(Criteria.sort('position', 'ASC'));
            return criteria;
        },
        productCriteria() {
            const criteria = new Criteria(1, 25);
            return criteria;
        },

        stateCriteria() {
            if (!this.testdemo.countryId) {
                return null;
            }

            const criteria = new Criteria(1, 25);
            criteria.addFilter(Criteria.equals('countryId', this.testdemo.countryId));
            return criteria;
        },
        testdemoRepository() {
            return this.repositoryFactory.create('test_demo');
        },

        mediaRepository() {
            return this.repositoryFactory.create('media');
        },

        customFieldSetRepository() {
            return this.repositoryFactory.create('custom_field_set');
        },

        customFieldSetCriteria() {
            const criteria = new Criteria(1, null);
            criteria.addFilter(
                Criteria.equals('relations.entityName', 'test_demo'),
            );

            return criteria;
        },

        mediaUploadTag() {
            return `sw-test-demo-detail--${this.testdemo.id}`;
        },

        tooltipSave() {
            if (this.acl.can('test_demo.editor')) {
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

        ...mapPropertyErrors('testdemo', ['name']),
    },

    watch: {
        testdemoId() {
            this.createdComponent();
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            Shopware.ExtensionAPI.publishData({
                id: 'sw-test-demo-detail__testdemo',
                path: 'testdemo',
                scope: this,
            });
            if (this.testdemoId) {
                this.loadEntityData();
                return;
            }

            Shopware.State.commit('context/resetLanguageToDefault');
            this.testdemo = this.testdemoRepository.create();
        },
        getCountryStates() {
            if (!this.country) {
                return Promise.resolve();
            }

            return this.countryStateRepository.search(this.stateCriteria).then((response) => {
                this.states = response;
            });
        },

        async loadEntityData() {
            this.isLoading = true;

            const [testdemoResponse, customFieldResponse] = await Promise.allSettled([
                this.testdemoRepository.get(this.testdemoId),
                this.customFieldSetRepository.search(this.customFieldSetCriteria),
            ]);

            if (testdemoResponse.status === 'fulfilled') {
                this.testdemo = testdemoResponse.value;
            }

            if (customFieldResponse.status === 'fulfilled') {
                this.customFieldSets = customFieldResponse.value;
            }

            if (testdemoResponse.status === 'rejected' || customFieldResponse.status === 'rejected') {
                this.createNotificationError({
                    message: this.$tc(
                        'global.notification.notificationLoadingDataErrorMessage',
                    ),
                });
            }

            this.isLoading = false;
        },

        abortOnLanguageChange() {
            return this.testdemoRepository.hasChanges(this.testdemo);
        },

        saveOnLanguageChange() {
            return this.onSave();
        },

        onChangeLanguage() {
            this.loadEntityData();
        },

        setMediaItem({ targetId }) {
            this.testdemo.mediaId = targetId;
        },

        setMediaFromSidebar(media) {
            this.testdemo.mediaId = media.id;
        },

        onUnlinkLogo() {
            this.testdemo.mediaId = null;
        },

        openMediaSidebar() {
            this.$refs.mediaSidebarItem.openContent();
        },

        onDropMedia(dragData) {
            this.setMediaItem({ targetId: dragData.id });
        },

        onSave() {
            if (!this.acl.can('test_demo.editor')) {
                return;
            }

            this.isLoading = true;

            this.testdemoRepository.save(this.testdemo).then(() => {
                this.isLoading = false;
                this.isSaveSuccessful = true;
                if (this.testdemoId === null) {
                    this.$router.push({ name: 'sw.test-demo.detail', params: { id: this.testdemo.id } });
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
            this.$router.push({ name: 'sw.test.demo.index' });
        },
    },
});
