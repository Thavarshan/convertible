<?php

namespace App\Jobs;

use Throwable;
use App\Models\Conversion;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Actions\Conversions\ConvertAudio;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessAudioConversion implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The conversion process instance.
     *
     * @var \App\Models\Conversion
     */
    protected $conversion;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Conversion $conversion
     *
     * @return void
     */
    public function __construct(Conversion $conversion)
    {
        $this->conversion = $conversion;
    }

    /**
     * Execute the job.
     *
     * @param \App\Actions\Conversions\ConvertAudio $converter
     *
     * @return void
     */
    public function handle(ConvertAudio $converter)
    {
        try {
            $converter->process($this->conversion);
        } catch (Throwable $e) {
            $this->conversion->updateStatus('failed');

            if (config('app.env') === 'local') {
                throw $e;
            }

            $this->fail($e);
        }
    }
}
