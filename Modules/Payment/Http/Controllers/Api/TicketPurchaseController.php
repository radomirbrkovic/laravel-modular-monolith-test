<?php

namespace Modules\Payment\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Event\Entities\Event;
use Modules\Payment\Http\Requests\Api\TicketPurchaseRequest;
use Modules\Payment\Services\TicketPurchaseService;
use Modules\Payment\Transformers\TicketPurchaseResource;

class TicketPurchaseController extends Controller
{

    public function __construct(private TicketPurchaseService $service)
    {

    }

    /**
     * @param int $eventId
     * @param TicketPurchaseRequest $request
     * @return \Illuminate\Http\JsonResponse|TicketPurchaseResource
     */
    public function store(int $eventId, TicketPurchaseRequest $request)
    {
        $data = $request->validated();
        $data['event_id'] = $eventId;

        try {
            return (new TicketPurchaseResource($this->service->create($data)))->response()->setStatusCode(200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
