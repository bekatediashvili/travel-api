<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToursListRequest;
use App\Http\Resources\TravelResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public  function index(Travel $travel, ToursListRequest $request){

       $tour =  Tour::where('travel_id' ,$travel->id)
        ->when($request->dateFrom, function ($query) use ($request){
           $query->where('starting_date', '>=', $request->dateFrom);
       })->when($request->dateTo, function ($query) use ($request){
           $query->where('starting_date', '<=', $request->dateTo);
       })->when($request->dateFrom, function ($query) use ($request){
           $query->where('starting_date', '>=', $request->dateFrom);
       })->when($request->priceTo, function ($query) use ($request){
           $query->where('starting_date', '<=', $request->priceTo);
       })->
       orderBy('starting_date')->paginate();
       return TravelResource::collection($tour);

    }
}
