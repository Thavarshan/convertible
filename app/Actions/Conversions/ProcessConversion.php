<?php

namespace App\Actions\Conversions;

use App\Jobs\ProcessAudioConversion;
use Emberfuse\Scorch\Contracts\Actions\CreatesNewResources;
use Illuminate\Support\Facades\DB;

class ProcessConversion implements CreatesNewResources
{
    /**
     * Process the given files conversion.
     *
     * @param array      $data
     * @param array|null $options
     *
     * @return mixed
     */
    public function convert(array $data, ?array $options = null)
    {
        return DB::transaction(function () use ($data, $options) {
            $conversion = $this->create($data, $options);

            ProcessAudioConversion::dispatch($conversion);

            return $conversion;
        });
    }

    /**
     * Create a new resource type.
     *
     * @param array      $data
     * @param array|null $options
     *
     * @return mixed
     */
    public function create(array $data, ?array $options = null)
    {
        $conversion = ($options['user'] ?? auth()->user())
            ->conversions()
            ->create([
                'name' => $data['name'],
                'audio_file_name' => $data['audio']->getClientOriginalName(),
            ]);

        $conversion->uploadAudioFile($data['audio']);

        return $conversion;
    }
}
