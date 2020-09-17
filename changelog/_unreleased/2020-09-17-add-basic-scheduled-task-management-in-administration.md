---
title:              Add basic scheduled task management in administration
issue:              NEXT-10847
author:             Felix Brucker
author_email:       felix@felixbrucker.com
author_github:      @felixbrucker
---
# Administration
* Added a `sw-settings-scheduled-task` setting module and corresponding `sw-settings-scheduled-task-list` page to view and manage scheduled tasks.
* Added a new method `runTask` to the `scheduled-task.api.service` to run a specific scheduled task as one-shot.

# Core
* Added a new `Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskService` with a `runScheduledTask` method to run a scheduled task as one-shot.
* Added a new api route `/api/v{version}/_action/scheduled-task/run/{scheduledTaskId}` to the `Shopware\Core\Framework\MessageQueue\ScheduledTask\Api\ScheduledTaskController` to handle one-shot running a scheduled task.
