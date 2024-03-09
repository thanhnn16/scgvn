<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\AgencyList;
use App\Models\Distributor;
use App\Models\Event;
use App\Models\Province;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $provinces = Province::all();
        $provinces->load(['agencies', 'distributors']);
        return view('agencies.agencies-management', [
            'provinces' => $provinces,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Agency $agency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agency $agency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agency $agency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agency $agency)
    {
        //
    }
//
//    public function filter(Request $request): JsonResponse
//    {
//        return response()->json(Agency::where('event_id', $request->event_id)->get());
//    }\

    public function getFromProvince(Request $request): JsonResponse
    {
        $agencies = Agency::where('province_id', $request->province_id)->get();

        $distributors = Distributor::where('province_id', $request->province_id)->get();

        return response()->json([
            'agencies' => $agencies,
            'distributors' => $distributors
        ]);
    }
}
