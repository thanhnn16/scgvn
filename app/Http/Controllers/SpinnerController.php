<?php

namespace App\Http\Controllers;

use App\Models\AgencyPrize;
use App\Models\Event;
use App\Models\EventAgency;
use App\Models\Prize;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpinnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $events = Event::all();
        return view('spinner.spinner-management', compact(['events']));
    }


    /**
     * Display the specified resource.
     */
    public function show(Event $event): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $event->load('prizes');
        $eventAgencies = $event->eventAgencies;
        $eventAgencies->load('agency');
        return view('spinner.index', compact('event', 'eventAgencies'));
    }

    public function awardPrize(Request $request): JsonResponse
    {
        try {
            $agency_id = $request->input('agency_id');
            $prize_id = $request->input('prize_id');
            $event_id = $request->input('event_id');

            $event_agency = EventAgency::where('agency_id', $agency_id)
                ->where('event_id', $event_id)
                ->first();

            $event_agency->prize_id = $prize_id;
            $event_agency->save();

            return response()->json(['message' => 'Prize awarded successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error awarding prize: ', $e->getMessage()],
                500);
        }
    }

}
