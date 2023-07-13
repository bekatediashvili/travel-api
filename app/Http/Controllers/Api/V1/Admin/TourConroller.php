<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourConroller extends Controller
{
    public function store(Travel $travel ,TourRequest $request){

      $tour =   $travel->tours->create([$request->validated()]);

        return new TourResource($tour);

    }
}