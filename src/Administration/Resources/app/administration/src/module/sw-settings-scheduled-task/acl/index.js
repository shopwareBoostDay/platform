Shopware.Service('privileges').addPrivilegeMappingEntry({
    category: 'permissions',
    parent: 'settings',
    key: 'scheduled_tasks',
    roles: {
        viewer: {
            privileges: [
                'scheduled_task:read'
            ],
            dependencies: []
        },
        editor: {
            privileges: [
                'scheduled_task:update'
            ],
            dependencies: [
                'scheduled_tasks.viewer'
            ]
        }
    }
});
