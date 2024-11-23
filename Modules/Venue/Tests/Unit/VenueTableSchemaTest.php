<?php

namespace Modules\Venue\Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Modules\Venue\Entities\Venue;
use Tests\TestCase;

class VenueTableSchemaTest extends TestCase
{
    private Venue $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Venue();
    }

    public function testVenuesTableExists(): void
    {
        $this->assertTrue(Schema::hasTable($this->model->getTable()));
    }
}
