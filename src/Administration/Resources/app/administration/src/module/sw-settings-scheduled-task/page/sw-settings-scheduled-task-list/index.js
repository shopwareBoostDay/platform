import template from './sw-settings-scheduled-task-list.html.twig';
import './sw-settings-scheduled-task-list.scss';

const { Component, Mixin, Context } = Shopware;
const { Criteria } = Shopware.Data;

Component.register('sw-settings-scheduled-task-list', {
    template,

    mixins: [
        Mixin.getByName('listing'),
        Mixin.getByName('placeholder'),
        Mixin.getByName('notification')
    ],

    inject: ['repositoryFactory', 'acl', 'scheduledTaskService'],

    data() {
        return {
            scheduledTasks: null,
            isLoading: false,
            sortBy: 'createdAt',
            sortDirection: 'DESC'
        };
    },

    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },

    computed: {
        scheduledTaskRepository() {
            return this.repositoryFactory.create('scheduled_task');
        }
    },

    methods: {
        async getList() {
            const criteria = new Criteria(this.page, this.limit);
            criteria.setTerm(this.term);
            criteria.addSorting(Criteria.sort(this.sortBy, this.sortDirection));

            this.isLoading = true;
            try {
                this.scheduledTasks = await this.scheduledTaskRepository.search(criteria, Context.api);
                this.total = this.scheduledTasks.total;
            } catch (error) {
                this.createNotificationError({
                    title: this.$t('global.default.error'),
                    message: this.$t('sw-settings-scheduled-task.list.errorLoad')
                });

                throw error;
            } finally {
                this.isLoading = false;
            }
        },

        async runScheduledTask(scheduledTask) {
            this.createNotificationInfo({
                message: this.$t('sw-settings-scheduled-task.list.manual-scheduled-task-execution.started', {
                    scheduledTaskName: scheduledTask.name
                })
            });
            try {
                await this.scheduledTaskService.runTask(scheduledTask.id);
                this.createNotificationSuccess({
                    message: this.$t('sw-settings-scheduled-task.list.manual-scheduled-task-execution.succeeded', {
                        scheduledTaskName: scheduledTask.name
                    })
                });
            } catch (error) {
                let errorMessage = this.$t('sw-settings-scheduled-task.list.unknownError');
                if (error.response && error.response.data && error.response.data.errors) {
                    errorMessage = error.response.data.errors.pop().detail;
                }
                this.createNotificationError({
                    message: this.$t('sw-settings-scheduled-task.list.manual-scheduled-task-execution.failed', {
                        scheduledTaskName: scheduledTask.name,
                        errorMessage
                    })
                });

                throw error;
            }
            await this.getList();
        },

        scheduledTaskColumns() {
            return [{
                property: 'name',
                label: 'sw-settings-scheduled-task.list.columnName',
                primary: true
            }, {
                property: 'runInterval',
                label: 'sw-settings-scheduled-task.list.columnRunInterval',
                inlineEdit: 'number'
            }, {
                property: 'lastExecutionTime',
                label: 'sw-settings-scheduled-task.list.columnLastExecutionTime'
            }, {
                property: 'nextExecutionTime',
                label: 'sw-settings-scheduled-task.list.columnNextExecutionTime',
                inlineEdit: 'datetime'
            }];
        }
    }
});
