<?php

namespace App\Http\Controllers;

use App\Imports\EventsImport;
use App\Imports\EventDataImport;
use App\Models\Event;
use App\Models\EventAgency;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $events = Event::all();
        return view('events.events-management', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('events.event-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $event = Event::create($request->all());
            $eventId = $event->id;
            return response()->json(['status' => 'success', 'message' => 'Tạo sự kiện thành công!', 'event_id' => $eventId]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $event->load(['agencies', 'prizes']);
        return view('events.event-detail', compact(['event']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        try {
            $event->update($request->all());
            return response()->json(['status' => 'success', 'message' => 'Cập nhật sự kiện thành công!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }


    public function eventHistory()
    {
        $events = Event::all()->load(['agencies', 'prizes']);
        return view('events.events-history', compact('events'));
    }

    /**
     * Download the template
     */
    public function download(): BinaryFileResponse
    {
        return response()->download(public_path('templates/events-template.xlsx'));
    }

    /**
     * Import the events
     */
    public function import(Request $request): RedirectResponse
    {
//        $request->validate([
//            'file' => 'required|mimes:xlsx,xls'
//        ]);
//
//        $file = $request->file('file');
//        Excel::import(new EventsImport, $file);
//
//        return redirect('/events')->with('success', 'Nhập sự kiện thành công!');
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls'
            ]);

            $file = $request->file('file');
            Excel::import(new EventsImport, $file);
            return redirect('/events')->with('success', 'Nhập sự kiện thành công! Vui lòng bấm vào Xem chi tiết để thêm Đại lý và Phần thưởng');
        } catch (Exception $e) {
            return redirect('/events')->with('error', $e->getMessage());
        }
    }

    public function importWithAllData(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls'
            ]);
            $file = $request->file('file');
            Excel::import(new EventDataImport, $file);
            return redirect('/events')->with('success', 'Nhập sự kiện thành công! Vui lòng bấm vào Xem chi tiết để kiểm tra');
        } catch (Exception $e) {
            return redirect('/events')->with('error', $e->getMessage());
        }
    }

    public function showAll(): JsonResponse
    {
        $events = Event::all();
        $events->load('agencies');
        $events->load('prizes');
        return response()->json($events);
    }

    public
    function showOngoing(): JsonResponse
    {
        $events = Event::whereBetween('start_date', [now(), now()->addDays(10)])->get();
        $events->load('agencies');
        $events->load('prizes');
        return response()->json($events);
    }

    public
    function showUpcoming(): JsonResponse
    {
        $events = Event::where('start_date', '>', now())->get();
        $events->load('agencies');
        $events->load('prizes');
        return response()->json($events);
    }

    public
    function showPast(): JsonResponse
    {
        $events = Event::where('end_date', '<', now())
            ->where('start_date', '<', now())
            ->get();
        $events->load('agencies');
        $events->load('prizes');
        return response()->json($events);
    }

    public
    function filter(Request $request): JsonResponse
    {
        $events = Event::where('start_date', '>=', $request->start_date)
            ->where('end_date', '<=', $request->end_date)
            ->get();
        $events->load('agencies');
        $events->load('prizes');
        return response()->json($events);
    }

    public function getEventData(Request $request): JsonResponse
{
    try {
        $event_id = $request->event_id;

        $event = Event::find($event_id);

        $agencies = EventAgency::where('event_id', $event_id)->with('prize')->get();

        $agencies->map(function ($item) {
            return $item->agency->province;
        })->unique('province_id');

        $prizes = $event->prizes;



        foreach ($prizes as $prize) {
            $prize->agencies = $prize->eventAgencies->pluck('agency')->unique('agency_id');
        }

        return response()->json(['agencies' => $agencies, 'prizes' => $prizes]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
}

}
