<?php

namespace Tests\Feature;

use App\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListStatusesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_get_all_statuses()
    {
        // $this->withoutExceptionHandling();

        $status1 = factory(Status::class)->create(['created_at' => now()->subDays(4)]);
        $status2 = factory(Status::class)->create(['created_at' => now()->subDays(3)]);
        $status3 = factory(Status::class)->create(['created_at' => now()->subDays(2)]);
        $status4 = factory(Status::class)->create(['created_at' => now()->subDays(1)]);

        $response = $this->getJson(route('statuses.index'));

        $response->assertSuccessful();

        $response->assertJson([
            'total' => 4
        ]);

        $response->assertJsonStructure([
            'data','total','first_page_url','last_page_url'
        ]);

        $this->assertEquals(
            $status4->id,
            $response->json('data.0.id')
        );
    }
}
