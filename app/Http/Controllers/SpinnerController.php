<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Prize;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SpinnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $events = Event::all();
        return view('spinner.spinner-management', compact('events'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('prizes');
        $event->load('agencies');
        return view('spinner.index', compact('event'));
    }

}
