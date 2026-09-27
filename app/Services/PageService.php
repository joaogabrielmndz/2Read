<?php

namespace App\Services;

use App\Jobs\ProcessWebPageJob;
use App\Models\User;

class PageService
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

    public function updatePage(User $user, int $id, array $data)
    {
        $page = $user->pages()->find($id);

        $user->pages()->updateExistingPivot($page, array_filter([
            'custom_title' => $data['custom_title'] ?? null,
            'is_read' => $data['is_read'],
            'is_archived' => $data['is_archived']
        ]), fn ($value) => !is_null($value));

        return $page->fresh();
    }
}
