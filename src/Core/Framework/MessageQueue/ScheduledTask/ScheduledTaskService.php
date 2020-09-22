<?php declare(strict_types=1);

namespace Shopware\Core\Framework\MessageQueue\ScheduledTask;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\MessageQueue\Handler\AbstractMessageHandler;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\Exception\ScheduledTaskNotFoundException;

class ScheduledTaskService
{
    /**
     * @var EntityRepositoryInterface
     */
    private $scheduledTaskRepository;

    /**
     * @var AbstractMessageHandler[]
     */
    private $taskHandler;

    public function __construct(
        EntityRepositoryInterface $scheduledTaskRepository,
        iterable $taskHandler
    ) {
        $this->scheduledTaskRepository = $scheduledTaskRepository;
        $this->taskHandler = $taskHandler;
    }

    public function runScheduledTask(string $scheduledTaskId, Context $context): void
    {
        $criteria = new Criteria([$scheduledTaskId]);
        /** @var ScheduledTaskEntity $scheduledTask */
        $scheduledTask = $this->scheduledTaskRepository->search($criteria, $context)->first();
        if ($scheduledTask === null) {
            throw new ScheduledTaskNotFoundException($scheduledTaskId);
        }

        // The status needs to be set to queued to allow running the task
        $this->scheduledTaskRepository->update([
            [
                'id' => $scheduledTaskId,
                'status' => ScheduledTaskDefinition::STATUS_QUEUED,
            ],
        ], $context);

        $className = $scheduledTask->getScheduledTaskClass();
        $task = new $className();
        $task->setTaskId($scheduledTaskId);

        foreach ($this->taskHandler as $handler) {
            if (!in_array($className, $handler::getHandledMessages(), true)) {
                continue;
            }

            $handler->handle($task);
        }
    }
}
