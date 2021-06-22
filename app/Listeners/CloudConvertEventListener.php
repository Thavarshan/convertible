<?php

namespace App\Listeners;

use App\Models\Conversion;
use CloudConvert\Models\Task;
use CloudConvert\Models\WebhookEvent;
use Emberfuse\Scorch\Support\Concerns\InteractsWithContainer;

class CloudConvertEventListener
{
    use InteractsWithContainer;

    /**
     * Habdle job finished event.
     *
     * @param \CloudConvert\Models\WebhookEvent $event
     *
     * @return void
     */
    public function onJobFinished(WebhookEvent $event)
    {
        $job = $event->getJob();

        $this->updateConversionStatus($job->getTag(), 'succeeded');

        $this->resolve(DownloadConverted::class)->download($job);
    }

    /**
     * Habdle job failed event.
     *
     * @param \CloudConvert\Models\WebhookEvent $event
     *
     * @return void
     */
    public function onJobFailed(WebhookEvent $event)
    {
        $job = $event->getJob();

        $this->updateConversionStatus($job->getTag(), 'failed');

        $failingTask = $job->getTasks()->whereStatus(Task::STATUS_ERROR)[0];

        $this->resolve('log')->error(
            'CloudConvert task failed: ' . $failingTask->getId()
        );
    }

    /**
     * Register subscription handlers.
     *
     * @param mixed $events
     *
     * @return void
     */
    public function subscribe($events): void
    {
        $events->listen(
            'cloudconvert-webhooks::job.finished',
            'App\Listeners\CloudConvertEventListener@onJobFinished'
        );

        $events->listen(
            'cloudconvert-webhooks::job.failed',
            'App\Listeners\CloudConvertEventListener@onJobFailed'
        );
    }

    /**
     * Update convirsion status.
     *
     * @param string $jobId
     * @param string $status
     *
     * @return void
     */
    public function updateConversionStatus(string $jobId, string $status): void
    {
        tap(
            Conversion::whereJobId($jobId)->first(),
            fn ($conversion) => $conversion->updateStatus($status)
        );
    }
}
