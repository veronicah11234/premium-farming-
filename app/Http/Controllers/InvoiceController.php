<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $invoices = Invoice::latest()->get();
    return view('invoices.index', compact('invoices'));
}

public function create()
{
    return view('invoices.create');
}

public function store(Request $request)
{
    Invoice::create([
        'invoice_number' => 'INV-' . time(),
        'client_id' => $request->client_id,
        'total' => $request->total,
        'paid' => $request->paid,
        'balance' => $request->total - $request->paid,
        'invoice_date' => now(),
    ]);

    return back()->with('success', 'Invoice created successfully');
}


    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
