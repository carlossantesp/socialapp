<?php

namespace Tests\Unit;

use App\Status;
use App\User;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_status_belongs_to_a_user()
    {
        $status = factory(Status::class)->create();

        $this->assertInstanceOf(User::class, $status->user);
    }
}
