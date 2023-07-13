<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelRequest;
use App\Http\Resources\TravelResource;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function store(TravelRequest $travelRequest)
    {

        $travel = Travel::create($travelRequest->validated());

        return new TravelResource($travel);

    }

    public function update(Travel $travel, TravelRequest $travelRequest)
    {

        $travel->update($travelRequest->validated());

        return new TravelResource($travel);

    }
}
