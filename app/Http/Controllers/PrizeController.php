<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use Exception;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('prizes.prizes-management');
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
        $event_id = $request->input('event_id');
        $prizes = $request->input('prizes');

        if (is_array($prizes)) {
            foreach ($prizes as $prize) {
                Prize::create([
                    'prize_name' => $prize['prize_name'],
                    'prize_qty' => $prize['prize_qty'],
                    'prize_desc' => $prize['prize_desc'],
                    'event_id' => $event_id
                ]);
            }
        } else {
            Prize::create([
                'prize_name' => $prizes['prize_name'],
                'prize_qty' => $prizes['prize_qty'],
                'prize_desc' => $prizes['prize_desc'],
                'event_id' => $event_id
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Tạo giải thưởng thành công!']);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Prize $prize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prize $prize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prize $prize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prize $prize)
    {
        //
    }
}
