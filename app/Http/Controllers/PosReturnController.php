<?php

namespace App\Http\Controllers;

use App\Models\PosReturn;
use Illuminate\Http\Request;

class PosReturnController extends Controller
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
        PosReturn::create([
            'sale_id' => $request->sale_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'amount_refunded' => $request->amount_refunded,
            'reason' => $request->reason,
        ]);
    
        return back()->with('success', 'Return processed');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(PosReturn $posReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PosReturn $posReturn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PosReturn $posReturn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PosReturn $posReturn)
    {
        //
    }
}
