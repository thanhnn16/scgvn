<?php

namespace App\Http\Controllers;

use App\Exports\AgencyProvinceExport;
use App\Models\Agency;
use App\Models\AgencyList;
use App\Models\Distributor;
use App\Models\Event;
use App\Models\Province;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
    public function store(Request $request): JsonResponse
    {
        try {
            $agency = Agency::create([
                'keywords' => $request->keywords,
                'agency_id' => $request->agency_id,
                'agency_name' => $request->agency_name,
                'province_id' => $request->province_id,
            ]);
            if ($agency) {
                return response()->json([
                    'message' => 'Agency created successfully',
                    'status' => 'success',
                ]);
            } else {
                return response()->json([
                    'message' => 'Agency creation failed',
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Agency $agency): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $agency->load('province');

        $eventAgencies = $agency->eventAgencies;
        $eventAgencies->load('prize', 'event');

//        load prizes in eventAgencies from prize_id


        return view('agencies.agencies-details', compact('agency', 'eventAgencies'));
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
    public function update(Request $request): JsonResponse
    {
        try {
            $updated = Agency::where('agency_id', $request->agency_id)
                ->update([
                    'keywords' => $request->keywords,
                    'agency_name' => $request->agency_name,
                    'province_id' => $request->province_id,
                ]);

            if ($updated) {
                return response()->json([
                    'message' => 'Agency updated successfully',
                    'status' => 'success',
                ]);
            } else {
                return response()->json([
                    'message' => 'No agency found with the provided ID',
                    'status' => 'error',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function download(): BinaryFileResponse
    {
        return response()->download(public_path('templates/tinh_daily_npp.xlsx'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            $deleted = DB::table('agencies')->where('agency_id', $request->agency_id)->delete();
            if ($deleted) {
                return response()->json([
                    'message' => 'Agency deleted successfully',
                    'status' => 'success',
                ]);
            } else {
                return response()->json([
                    'message' => 'No agency found with the provided ID',
                    'status' => 'error',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
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

    public function export(): BinaryFileResponse
    {
        return Excel::download(new AgencyProvinceExport(), 'provinces_and_agencies.xlsx');
    }
}
