<?php

namespace App\Jobs;

use App\Enums\PageScrappingStatus;
use App\Models\Page;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Mews\Purifier\Facades\Purifier;
use Throwable;

class ProcessWebPageJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $hash_url,
        private string $page_url,
        private string $title,
        private string $content,
        private User $user
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $clean_html = Purifier::clean($this->content);

        $page = Page::firstOrCreate(
            ['hash_url' => $this->hash_url],
            [
                'page_url' => $this->page_url,
                'title' => $this->title,
                'content' => $clean_html,
                'scrapping_status' => PageScrappingStatus::Done
            ]
        );

        $this->user->pages()->syncWithoutDetaching([
            $page->id => ['custom_title' => $this->title]
        ]);
    }

    public function fail(Throwable $exception): void
    {
        Page::where('hash_url', $this->hash_url)->update([
            'scrapping_status' => PageScrappingStatus::Failed
        ]);
    }
}
