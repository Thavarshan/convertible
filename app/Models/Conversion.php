<?php

namespace App\Models;

use App\Events\ConversionStatusUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Traits\Tappable;
use App\Models\Concerns\InteractsWithFiles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversion extends Model
{
    use HasFactory;
    use Tappable;
    use InteractsWithFiles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'audio_file_name',
        'status',
        'user_id',
        'audio_file_path',
        'download_path',
        'job_id',
    ];

    /**
     * Get the user this conversion belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full path to the audio file.
     *
     * @return string
     */
    public function audioFile(): string
    {
        return Storage::disk('public')->path($this->audio_file_path);
    }

    /**
     * Update conversion status and notify user.
     *
     * @param string $status
     *
     * @return void
     */
    public function updateStatus(string $status): void
    {
        $this->forceFill(compact('status'))->saveQuietly();

        ConversionStatusUpdated::dispatch($this);
    }

    /**
     * Provide download link to converted file.
     *
     * @return string
     */
    public function downloadLink(): string
    {
        return route('conversions.show', $this);
    }
}
