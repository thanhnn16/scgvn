<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PrizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
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
    public function store(Request $request): JsonResponse
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
        try {
            $prize->update($request->all());
            return response()->json(['status' => 'success', 'message' => 'Cập nhật giải thưởng thành công!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prize $prize): JsonResponse
    {
        try {
            $prize->delete();
            return response()->json(['status' => 'success', 'message' => 'Xóa giải thưởng thành công!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
