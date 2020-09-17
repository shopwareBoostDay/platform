import './page/sw-settings-scheduled-task-list';

import './acl';

const { Module } = Shopware;

Module.register('sw-settings-scheduled-task', {
    type: 'core',
    name: 'settings-scheduled-task',
    title: 'sw-settings-scheduled-task.general.mainMenuItemGeneral',
    description: 'sw-settings-scheduled-task.general.description',
    color: '#9AA8B5',
    icon: 'default-action-settings',
    favicon: 'icon-module-settings.png',
    entity: 'scheduled_task',

    routes: {
        index: {
            component: 'sw-settings-scheduled-task-list',
            path: 'index',
            meta: {
                parentPath: 'sw.settings.index',
                privilege: 'scheduled_tasks.viewer'
            }
        }
    },

    settingsItem: {
        group: 'shop',
        to: 'sw.settings.scheduled.task.index',
        icon: 'default-arrow-360-full',
        privilege: 'scheduled_tasks.viewer'
    }
});
