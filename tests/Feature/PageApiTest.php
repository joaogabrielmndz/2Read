<?php 

namespace Tests\Feature;

use App\Enums\PageScrappingStatus;
use App\Jobs\ProcessWebPageJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PageApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_receive_page_data_and_dispatch_job(): void
    {
        Queue::fake();

        $user = User::factory()->create();

        $payload = [
            'url'   => 'https://exemplo.com/artigo-teste',
            'title' => 'Artigo de Teste',
            'html'  => '<h1>Título</h1><p>Conteúdo de teste com script <script>alert("xss")</script></p>'
        ];

        $response = $this->actingAs($user)
            ->postJson('/api/v1/pages', $payload);

        $response->assertStatus(202)
                 ->assertJsonStructure(['msg', 'hash_url']);

        Queue::assertPushed(ProcessWebPageJob::class);
    }

    public function test_job_cleans_html_and_saves_to_database(): void
    {
        $user = User::factory()->create();
        $url = 'https://exemplo.com/artigo-teste';
        $hashUrl = hash('sha256', $url);
        $dirtyHtml = '<div><p>Texto limpo</p><script>evilCode()</script></div>';

        $job = new ProcessWebPageJob(
            $hashUrl,
            $url,
            'Título do Artigo',
            $dirtyHtml,
            $user
        );

        $job->handle();

        $this->assertDatabaseHas('pages', [
            'hash_url' => $hashUrl,
            'page_url' => $url,
            'title'    => 'Título do Artigo',
            'scrapping_status' => PageScrappingStatus::Done->value
        ]);

        $this->assertDatabaseMissing('pages', [
            'content' => 'evilCode()'
        ]);

        $this->assertDatabaseHas('user_page', [
            'user_id' => $user->id,
            'custom_title' => 'Título do Artigo'
        ]);
    }
}