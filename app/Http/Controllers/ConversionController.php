<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Conversion;
use Illuminate\Http\Response;
use App\Http\Requests\ConversionRequest;
use App\Http\Responses\ConversionResponse;
use App\Actions\Conversions\ProcessConversion;

class ConversionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Dashboard/Home', [
            'conversions' => Conversion::latest()->paginate(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ConversionRequest       $request
     * @param \App\Actions\Conversions\ProcessConversion $converter
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ConversionRequest $request, ProcessConversion $converter)
    {
        $converter->convert(
            $request->validated(),
            ['user' => $request->user()]
        );

        return ConversionResponse::dispatch();
    }

    /**
     * Download the specified resource from storage.
     *
     * @param \App\Models\Conversion $conversion
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Conversion $conversion)
    {
        return Response::download(
            $conversion->download,
            $conversion->audio_file_name);
    }
}
