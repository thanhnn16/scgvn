<?php

namespace App\Http\Controllers;

use App\Models\EventAgency;
use Exception;
use Illuminate\Http\Request;

class EventAgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        try {
            EventAgency::create($request->all());
            return response()->json(['status' => 'success', 'message' => 'Tạo đối tác sự kiện thành công!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EventAgency $eventAgency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventAgency $eventAgency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EventAgency $eventAgency)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventAgency $eventAgency)
    {
        //
    }
}
