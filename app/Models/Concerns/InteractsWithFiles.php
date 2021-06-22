<?php

namespace App\Models\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait InteractsWithFiles
{
    /**
     * Update the user's audio file.
     *
     * @param \Illuminate\Http\UploadedFile $file
     *
     * @return void
     */
    public function uploadAudioFile(UploadedFile $file): void
    {
        $this->forceFill([
            'audio_file_path' => $file->storePublicly(
                'audio-files',
                ['disk' => $this->audioFileDisk()]
            ),
        ])->save();
    }

    /**
     * Delete the user's audio file.
     *
     * @return void
     */
    public function deleteAudioFile(): void
    {
        Storage::disk($this->audioFileDisk())->delete($this->audio_file_path);

        $this->forceFill(['audio_file_path' => null])->save();
    }

    /**
     * Get the disk that audio files should be stored on.
     *
     * @return string
     */
    protected function audioFileDisk(): string
    {
        return isset($_ENV['CLOUD_ARTIFACT_NAME']) ? 's3' : 'public';
    }
}
