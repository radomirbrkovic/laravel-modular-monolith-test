<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
abstract class BaseTestCase extends TestCase
{
    use RefreshDatabase;
}
