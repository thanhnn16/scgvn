<?php

namespace App\Http\Controllers;

use App\Imports\EventDataImport;
use App\Imports\ProvinceDataImport;
use App\Models\Province;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Maatwebsite\Excel\Facades\Excel;

class ProvinceController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        //
    }

    public function import(Request $request): \Illuminate\Foundation\Application|Redirector|RedirectResponse|Application
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls'
            ]);
            $file = $request->file('file');
            Excel::import(new ProvinceDataImport(), $file);
            return redirect('/agencies')->with('success', 'Nhập dữ liệu thành công!');
        } catch (Exception $e) {
            return redirect('/agencies')->with('error', $e->getMessage());
        }
    }
}
