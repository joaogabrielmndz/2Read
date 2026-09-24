<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageStoreRequest;
use App\Services\PageServices;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function __construct(
        private PageServices $processService
    ){}

    public function store(PageStoreRequest $request)
    {
        $data = $request->validated();

        $this->processService->dispatchProcessing(data: $data, user: $request->user());

        return response()->json([
            'msg' => 'Pagina enviada para processamento',
            'status' => 'processing'
        ], Response::HTTP_ACCEPTED);
    }
}
