<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Conversion;
use Illuminate\Http\UploadedFile;
use App\Jobs\ProcessAudioConversion;
use Illuminate\Support\Facades\Queue;
use App\Actions\Conversions\ProcessConversion;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessConversionTest extends TestCase
{
    use RefreshDatabase;

    public function testConversion()
    {
        Queue::fake();

        $converter = new ProcessConversion();

        $conversion = $converter->convert([
            'name' => 'SampleFile',
            'audio' => UploadedFile::fake()->create('audio.wav'),
        ], ['user' => create(User::class)]);

        $this->assertInstanceOf(Conversion::class, $conversion);
        $this->assertEquals('SampleFile', $conversion->name);
    }

    public function testConversionDispatchesJob()
    {
        Queue::fake();

        $converter = new ProcessConversion();

        Queue::assertNothingPushed();

        $converter->convert([
            'name' => 'SampleFile',
            'audio' => UploadedFile::fake()->create('audio.wav'),
        ], ['user' => create(User::class)]);

        Queue::assertPushed(ProcessAudioConversion::class);
    }
}
