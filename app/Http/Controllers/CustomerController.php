<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->get();
        return view('shop.customers', compact('customers'));
    }

    public function store(Request $request)
    {
        Customer::create([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('customers.index')
                         ->with('success', 'Customer added successfully.');
    }

    public function destroy($id)
{
    Customer::findOrFail($id)->delete();

    return redirect()->route('customers.index')
                     ->with('success', 'Customer removed successfully.');
}

}
