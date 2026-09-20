<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessWebPageJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'url' => ['required', 'url'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string']
        ]);

        $hash_url = hash(algo: 'sha256', data: $data['url']);

        ProcessWebPageJob::dispatch(
            $hash_url,
            $data['url'],
            $data['title'],
            $data['content'],
            $request->user()
        );

        return response()->json([
            'msg' => 'Pagina enviada para processamento',
            'hash_url' => $hash_url
        ], Response::HTTP_ACCEPTED);
    }
}
