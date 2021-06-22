<?php

namespace App\Http\Responses;

use Emberfuse\Scorch\Http\Responses\Response;
use Illuminate\Contracts\Support\Responsable;

class ConversionResponse extends Response implements Responsable
{
    /**
     * The response message.
     *
     * @var string
     */
    protected $message = 'Conversion process underway, you will receive an email once the conversion process is completed.';

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return $request->expectsJson()
            ? $this->json('', 201)
            : $this->redirectToRoute('home', [], 303)
                ->banner(__($this->message));
    }
}
