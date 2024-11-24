<?php

namespace Modules\Event\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Event\Http\Requests\Api\EventRequest;
use Modules\Event\Services\EventCrudService;
use Modules\Event\Transformers\EventResource;

class EventController extends Controller
{

    public function __construct(private EventCrudService $service)
    {

    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return EventResource::collection($this->service->list());
    }


    /**
     * @param EventRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EventRequest $request)
    {
        return (new EventResource($this->service->create($request->validated())))
            ->response()->setStatusCode(Response::HTTP_CREATED);
    }


    /**
     * @param $id
     * @return EventResource
     */
    public function show($id)
    {
        return new EventResource($this->service->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('event::edit');
    }


    /**
     * @param EventRequest $request
     * @param $id
     * @return EventResource
     */
    public function update(EventRequest $request, $id)
    {
        return new EventResource($this->service->update($id, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
