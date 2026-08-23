<?php

namespace Tests\Feature\Console;

use Tests\TestCase;

class InspireCommandTest extends TestCase
{
    public function test_inspire_command_runs_successfully(): void
    {
        $this->artisan('inspire')
            ->assertExitCode(0);
    }
}