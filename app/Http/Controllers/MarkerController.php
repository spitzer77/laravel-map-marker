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
    public function index(){

        $threshold = Carbon::now()->subMinutes(10);
        //$toDel = Marker::where('created_at', '<', $threshold)->delete();
        //var_dump($toDel);

        //$markers = Marker::all();
        //$markers = Marker::orderBy('id', 'desc')->get();
        $markers = Marker::latest()->get();
        $markers = MarkerResource::collection($markers)->resolve();

        return inertia('Marker/Index', compact('markers'));
    }

    public function store(StoreRequest $request){

        $data = $request->validated();
        $marker = Marker::create($data);

        //event(new StoreMarkerEvent($marker));
        broadcast(new StoreMarkerEvent($marker))->toOthers();

        return MarkerResource::make($marker)->resolve();
        //return redirect()->route('marker.index');
    }


}
