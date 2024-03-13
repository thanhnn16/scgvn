<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Event;
use App\Models\EventAgency;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventAgencyController extends Controller
{

    public function store(Request $request): JsonResponse
    {
        try {
            EventAgency::create($request->all());
            return response()->json(['status' => 'success', 'message' => 'Tạo đối tác sự kiện thành công!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function storeOrUpdate(Request $request): JsonResponse
    {
        try {
            $eventAgency = EventAgency::where('event_id', $request->event_id)->where('agency_id', $request->agency_id)->first();
            if ($eventAgency) {
                $eventAgency->update($request->all());
            } else {
                EventAgency::create($request->all());
            }
            return response()->json(['status' => 'success', 'message' => 'Tạo đối tác sự kiện thành công!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request): JsonResponse
    {
        try {
            $eventAgency = EventAgency::where('event_id', $request->event_id)
                ->where('agency_id', $request->agency_id)
                ->first();

            if ($eventAgency) {
                DB::table('event_agencies')
                    ->where('event_id', $request->event_id)
                    ->where('agency_id', $request->agency_id)
                    ->delete();
                return response()->json(['status' => 'success', 'message' => 'Xóa đối tác sự kiện thành công!']);
            } else {
                return response()->json(['error' => 'EventAgency not found']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function addPrize(Request $request): JsonResponse
    {
        try {
            $eventAgency = EventAgency::where('agency_id', $request->agency_id)
                ->first();
            if ($eventAgency) {
                DB::table('event_agencies')
                    ->where('agency_id', $request->agency_id)
                    ->where('event_id', $request->event_id)
                    ->update(['prize_id' => $request->prize_id]);
                return response()->json(['status' => 'success', 'message' => 'Thêm giải thưởng thành công!']);
            } else {
                return response()->json(['error' => 'EventAgency not found']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function register(Request $request): JsonResponse
    {
        try {
            $agency = Agency::where('agency_id', $request->agency_id)->first();
            if ($agency) {
                $keywords = $agency->keywords;
                $event = Event::where('content', 'like', '%' . $keywords . '%')->first();
                if ($event) {
                    EventAgency::create([
                        'event_id' => $event->id,
                        'agency_id' => $agency->agency_id,
                    ]);
                    return response()->json(['status' => 'success', 'message' => 'Đăng ký sự kiện thành công!']);
                } else {
                    return response()->json(['error' => 'Event not found']);
                }
            } else {
                return response()->json(['error' => 'Agency not found']);
            }
        }catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
