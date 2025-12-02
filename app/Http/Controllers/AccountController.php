<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Client;
class AccountController extends Controller
{
    public function clients() {
        $clients = Client::paginate(40);
        return view('pos.clients', compact('clients'))->with('mode','pos');
    }
    public function clientTerms() {
        $clients = Client::paginate(40);
        return view('pos.client-terms', compact('clients'))->with('mode','pos');
    }
    public function invoices() { /* list invoices */ }
    public function receipts() { /* list receipts */ }
    public function creditNotes() { /* list credit notes */ }
    public function pettyCash() { /* list petty cash entries */ }
}
