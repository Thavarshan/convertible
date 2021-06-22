<?php

namespace App\Actions\Conversions;

use App\Models\Conversion;
use Illuminate\Support\Str;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;
use CloudConvert\CloudConvert;

class ConvertAudio
{
    /**
     * The CloudConverter client instance.
     *
     * @var \CloudConvert\CloudConvert
     */
    protected $client;

    /**
     * The conversion process job instance.
     *
     * @var \CloudConvert\Models\Job
     */
    protected $job;

    /**
     * Task processes lookup.
     *
     * @var array
     */
    protected $processes = [
        'import/upload' => 'upload-aud-file',
        'convert' => 'convert-aud-file',
        'export/url' => 'export-aud-file',
    ];

    /**
     * Create new instance of Audio converter action.
     *
     * @param \CloudConvert\CloudConvert $client
     *
     * @return void
     */
    public function __construct(CloudConvert $client)
    {
        $this->client = $client;
    }

    /**
     * Convert audio file.
     *
     * @param \App\Models\Conversion $conversion
     *
     * @return void
     */
    public function process(Conversion $conversion): void
    {
        $this->createJob()
            ->configureTask('import/upload')
            ->configureTask('convert')
            ->configureTask('export/url');

        tap($conversion, function ($conversion) {
            $conversion->forceFill([
                'job_id' => $this->job->getTag(),
            ])->saveQuietly();
        });

        $this->client->jobs()->create($this->job);

        $this->client->tasks()->upload(
            $this->job->getTasks()->whereName('upload-aud-file')[0],
            fopen($conversion->audioFile(), 'r')
        );
    }

    /**
     * Create new job instance.
     *
     * @return \App\Actions\Conversions\ConvertAudio
     */
    protected function createJob(): ConvertAudio
    {
        $this->job = (new Job())->setTag(Str::random());

        return $this;
    }

    /**
     * Configure task for job.
     *
     * @return \App\Actions\Conversions\ConvertAudio
     */
    public function configureTask(string $process): ConvertAudio
    {
        $task = $this->createTask($process);

        if ($process === 'convert') {
            $task->set('input', 'upload-aud-file')
                ->set('output_format', env('CONVERSION_FORMAT', 'mp3'));
        } elseif ($process === 'export/url') {
            $task->set('input', 'convert-aud-file');
        }

        $this->job->addTask($task);

        return $this;
    }

    /**
     * Create new task instance.
     *
     * @return \CloudConvert\Models\Task
     */
    public function createTask(string $process): Task
    {
        return new Task($process, $this->processes[$process]);
    }
}
