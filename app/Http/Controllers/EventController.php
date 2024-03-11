<?php

namespace App\Http\Controllers;

use App\Exports\EventsExport;
use App\Imports\EventsImport;
use App\Imports\EventDataImport;
use App\Models\Event;
use App\Models\EventAgency;
use App\Models\Prize;
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
        $events->load('eventAgencies');
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
//        $event->agencies = $event->eventAgencies->map(function ($item) {
//            return $item->agency->province;
//        })->unique('province_id');

        $event_agencies = $event->eventAgencies;
        $event_agencies->map(function ($item) {
            return $item->agency->province;
        })->unique('province_id');

        $prizes = $event->prizes;
        foreach ($prizes as $prize) {
            $prize->event_agencies = $prize->eventAgencies;
        }

        return view('events.event-detail', compact(['event', 'event_agencies', 'prizes']));
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
    public function destroy(Event $event): JsonResponse
    {
        try {
            $event->delete();
            return response()->json(['status' => 'success', 'message' => 'Xóa sự kiện thành công!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    public function eventHistory(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $events = Event::all()->load(['eventAgencies', 'prizes']);
//        $events = Event::all()->load(['eventAgencies', 'prizes']);
        return view('events.events-history', compact('events'));
    }

    /**
     * Download the template
     */
    public function download(): BinaryFileResponse
    {
        return response()->download(public_path('templates/scgvn-data.xlsx'));
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

    public function export(Event $event): BinaryFileResponse
    {
        return Excel::download(new EventsExport($event), 'event.xlsx');
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
        $events->load('eventAgencies');
//        $events->load('prizes');
        return response()->json($events);
    }

    public
    function showOngoing(): JsonResponse
    {
        $events = Event::whereBetween('start_date', [now(), now()->addDays(10)])->get();
        $events->load('eventAgencies');
//        $events->load('prizes');
        return response()->json($events);
    }

    public
    function showUpcoming(): JsonResponse
    {
        $events = Event::where('start_date', '>', now())->get();
        $events->load('eventAgencies');
//        $events->load('prizes');
        return response()->json($events);
    }

    public
    function showPast(): JsonResponse
    {
        $events = Event::where('end_date', '<', now())
            ->where('start_date', '<', now())
            ->get();
        $events->load('eventAgencies');
//        $events->load('prizes');
        return response()->json($events);
    }

    public
    function filter(Request $request): JsonResponse
    {
        $events = Event::where('start_date', '>=', $request->start_date)
            ->where('end_date', '<=', $request->end_date)
            ->get();
        $events->load('eventAgencies');
//        $events->load('prizes');
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

            $prizes = $event->prizes->load('eventAgencies');

            foreach ($prizes as $prize) {
                $prize->event_agencies = $prize->eventAgencies->load('agency');
            }

            return response()->json(['agencies' => $agencies, 'prizes' => $prizes]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

//    create function to duplicate the event with new title
    public function duplicateEvent(Request $request): JsonResponse
    {
        try {
            $event = Event::find($request->event_id);
            $newEvent = $event->replicate();
            $newEvent->title = $request->title;
            $newEvent->save();

            foreach ($event->eventAgencies as $eventAgency) {
                $newEventAgency = $eventAgency->replicate();
                $newEventAgency->event_id = $newEvent->id;
                $newEventAgency->prize_id = null;
                $newEventAgency->save();
            }

            foreach ($event->prizes as $prize) {
                $newPrize = $prize->replicate();
                $newPrize->event_id = $newEvent->id;
                $newPrize->save();
            }

            return response()->json(['status' => 'success', 'message' => 'Sự kiện đã được sao chép!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function backup(): BinaryFileResponse|JsonResponse
    {
        try {
            $command = "mysqldump -u " . env('DB_USERNAME') . " -p" . env('DB_PASSWORD') . " " . env('DB_DATABASE') . " > " . public_path('backup.sql') . " 2>&1";
            exec($command, $output, $return_var);
            if ($return_var !== 0) {
                return response()->json(['error' => implode("\n", $output)]);
            }
            return response()->download(public_path('backup.sql'));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function reset(): \Illuminate\Contracts\Foundation\Application|Application|RedirectResponse|\Illuminate\Routing\Redirector
    {
//        write function to delete all data in events, event_agencies, prizes table
        try {
            Event::truncate();
            EventAgency::truncate();
            Prize::truncate();
            return redirect('/events')->with('success', 'Xóa dữ liệu thành công!');
        } catch (Exception $e) {
            return redirect('/events')->with('error', $e->getMessage());
        }
    }
}
