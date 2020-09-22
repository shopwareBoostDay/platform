<?php declare(strict_types=1);

namespace Shopware\Core\Framework\MessageQueue\ScheduledTask\Exception;

use Shopware\Core\Framework\ShopwareHttpException;

class ScheduledTaskNotFoundException extends ShopwareHttpException
{
    public function __construct(string $scheduledTaskId)
    {
        parent::__construct('No scheduled task found with ID "{{ scheduledTaskId }}"', [
            'scheduledTaskId' => $scheduledTaskId,
        ]);
    }

    public function getErrorCode(): string
    {
        return 'FRAMEWORK__SCHEDULED_TASK_NOT_FOUND';
    }
}
