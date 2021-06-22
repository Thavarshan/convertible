<?php

namespace Tests\Feature\Conversion;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConvertAudioFileTest extends TestCase
{
    use RefreshDatabase;

    public function testConvertAudioFile()
    {
        $this->withoutEvents();

        Queue::fake();

        $this->signIn();

        $response = $this->post('convert', [
            'name' => 'SampleFile',
            'audio' => UploadedFile::fake()->create('audio.wav'),
        ]);

        $response->assertStatus(303);
        $response->assertSessionHasNoErrors();
    }

    public function testConvertAudioFileThroughJsonRequest()
    {
        $this->withoutEvents();

        Queue::fake();

        $this->signIn();

        $response = $this->postJson('convert', [
            'name' => 'SampleFile',
            'audio' => UploadedFile::fake()->create('audio.wav'),
        ]);

        $response->assertStatus(201);
    }
}
