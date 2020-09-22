<?php declare(strict_types=1);

namespace Shopware\Core\Framework\MessageQueue\ScheduledTask\Api;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskService;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\Scheduler\TaskScheduler;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"api"})
 */
class ScheduledTaskController extends AbstractController
{
    /**
     * @var TaskScheduler
     */
    private $taskScheduler;

    /**
     * @var ScheduledTaskService
     */
    private $scheduledTaskService;

    public function __construct(TaskScheduler $taskScheduler, ScheduledTaskService $scheduledTaskService)
    {
        $this->taskScheduler = $taskScheduler;
        $this->scheduledTaskService = $scheduledTaskService;
    }

    /**
     * @Route("/api/v{version}/_action/scheduled-task/run", name="api.action.scheduled-task.run", methods={"POST"})
     */
    public function runScheduledTasks(): JsonResponse
    {
        $this->taskScheduler->queueScheduledTasks();

        return $this->json(['message' => 'Success']);
    }

    /**
     * @Route("/api/v{version}/_action/scheduled-task/run/{scheduledTaskId}", name="api.action.scheduled-task.run-task", methods={"POST"})
     */
    public function runScheduledTask(string $scheduledTaskId, Context $context): JsonResponse
    {
        $this->scheduledTaskService->runScheduledTask($scheduledTaskId, $context);

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/api/v{version}/_action/scheduled-task/min-run-interval", name="api.action.scheduled-task.min-run-interval", methods={"GET"})
     */
    public function getMinRunInterval(): JsonResponse
    {
        return $this->json(['minRunInterval' => $this->taskScheduler->getMinRunInterval()]);
    }
}
