<?php

namespace App\Http\Controllers;

use App\Events\StoreMarkerEvent;
use App\Http\Requests\Marker\StoreRequest;
use App\Http\Resources\Marker\MarkerResource;
use App\Models\Marker;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    public function index()
    {
        $markers = Marker::latest()->get();
        $markers = MarkerResource::collection($markers)->resolve();

        return inertia('Marker/Index', compact('markers'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $marker = Marker::create($data);

        broadcast(new StoreMarkerEvent($marker))->toOthers();

        return MarkerResource::make($marker)->resolve();
    }
}
