<?php

namespace Modules\Event\Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Modules\Event\Entities\Event;
use Modules\Venue\Entities\Venue;
use Tests\TestCase;

class EventTableSchemaTest extends TestCase
{
    private Event $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Event();
    }

    public function testEventsTableExists(): void
    {
        $this->assertTrue(Schema::hasTable($this->model->getTable()));
    }

    public function testEventsTableHasCorrectColumns(): void
    {
        $this->assertTrue(Schema::hasColumns($this->model->getTable(),
            $this->model->getFillable()
        ));
    }
}
