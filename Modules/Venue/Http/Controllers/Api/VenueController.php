<?php

namespace Modules\Venue\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
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

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('venue::create');
    }


    public function store(VenueRequest $request)
    {
        $venue = $this->service->create($request->validated());
        return (new VenueResource($venue))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('venue::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('venue::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
