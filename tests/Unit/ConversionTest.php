<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Conversion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConversionTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToUser()
    {
        $conversion = create(Conversion::class);

        $this->assertInstanceOf(User::class, $conversion->user);
    }

    public function testGetPathToAudioFile()
    {
        $conversion = create(Conversion::class, [
            'audio_file_path' => 'audio-files/randomfile.wav',
        ]);

        $this->assertEquals(
            Storage::disk('public')->path($conversion->audio_file_path),
            $conversion->audioFile()
        );
    }

    public function testUpdateStatus()
    {
        $this->withoutEvents();

        $conversion = create(Conversion::class);

        $this->assertEquals('pending', $conversion->status);

        $conversion->updateStatus('succeeded');

        $this->assertEquals('succeeded', $conversion->fresh()->status);
    }
}
