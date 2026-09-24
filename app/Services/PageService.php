<?php

namespace App\Services;

use App\Jobs\ProcessWebPageJob;
use App\Models\User;

class PageServices
{
    /**
     * Create a new class instance.
     */
    public function __construct(

    ){}

    /**
     * Makes Validation and Dispatch on queue
     * @param array $data
     * @param \App\Models\User $user
     * 
     * @return void
     */
    public function dispatchProcessing(array $data, User $user): void
    {
        $hash_url = hash(algo: 'sha256', data: $data['url']);

        ProcessWebPageJob::dispatch(
            $hash_url,
            $data['url'],
            $data['title'],
            $data['content'],
            $user
        );
    }
}
