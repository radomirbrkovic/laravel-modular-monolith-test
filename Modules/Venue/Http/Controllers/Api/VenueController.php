<?php

namespace Modules\Venue\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Venue\Entities\Venue;
use Modules\Venue\Http\Requests\Api\VenueRequest;
use Modules\Venue\Services\VenueCrudService;
use Modules\Venue\Transformers\VenueResource;

class VenueController extends Controller
{

    public function __construct(private VenueCrudService $service)
    {

    }

    public function index()
    {
        return VenueResource::collection($this->service->list());
    }


    public function store(VenueRequest $request)
    {
        $venue = $this->service->create($request->validated());
        return (new VenueResource($venue))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param Venue $venue
     * @return VenueResource
     */
    public function show(Venue $venue)
    {
        return new VenueResource($venue);
    }

    /**
     * @param VenueRequest $request
     * @param $id
     * @return VenueResource
     */
    public function update(VenueRequest $request, $id)
    {
        return new VenueResource($this->service->update($id, $request->validated()));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function destroy($id)
    {
        $this->service->delete($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
