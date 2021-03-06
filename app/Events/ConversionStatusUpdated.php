<?php

namespace App\Events;

use App\Models\Conversion;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConversionStatusUpdated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * The conversion instance.
     *
     * @var \App\Models\Conversion
     */
    protected $conversion;

    /**
     * Create a new event instance.
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
     * Get the user the conversion belongs to.
     *
     * @return \App\Models\User
     */
    public function user(): User
    {
        return $this->conversion->user;
    }

    /**
     * Get the conversion instance.
     *
     * @return \App\Models\Conversion
     */
    public function conversion(): Conversion
    {
        return $this->conversion;
    }
}
