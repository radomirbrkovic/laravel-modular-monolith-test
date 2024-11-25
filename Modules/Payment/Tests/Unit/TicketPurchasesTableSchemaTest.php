<?php

namespace Modules\Payment\Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Modules\Payment\Entities\TicketPurchase;
use Tests\TestCase;

class TicketPurchasesTableSchemaTest extends TestCase
{
    private TicketPurchase $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new TicketPurchase();
    }

    public function testTicketPurchasesTableExists(): void
    {
        $this->assertTrue(Schema::hasTable($this->model->getTable()));
    }

    public function testTicketPurchasesTableHasCorrectColumns(): void
    {
        $this->assertTrue(Schema::hasColumns($this->model->getTable(),
            $this->model->getFillable()
        ));
    }
}
