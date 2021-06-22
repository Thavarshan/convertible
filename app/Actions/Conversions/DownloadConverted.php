<?php

namespace App\Actions\Conversions;

use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use Illuminate\Support\Facades\Storage;

class DownloadConverted
{
    /**
     * The conversion client instance.
     *
     * @var \CloudConvert\CloudConvert
     */
    protected $client;

    /**
     * Create new instance of Conversion downloaded.
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
     * Download the end results of the job in question.
     *
     * @param \CloudConvert\Models\Job $job
     *
     * @return void
     */
    public function download(Job $job): void
    {
        collect($job->getExportUrls())->each(function ($file) {
            stream_copy_to_stream(
                $this->client->getHttpTransport()->download($file->url)->detach(),
                fopen(Storage::disk('public')->path('downloads/' . $file->filename), 'w')
            );
        });
    }
}
