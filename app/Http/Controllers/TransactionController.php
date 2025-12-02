<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use App\Models\StockMovement;
use App\Models\StockTake;

class TransactionController extends Controller
{
    public function goodsReceived()
{
    $stores = \App\Models\Store::all();
    $items  = \App\Models\Product::all(); // ← ADD THIS LINE

    return view('pos.goods-received', compact('stores', 'items'));
}


    public function storeGoodsReceived(Request $r) {
        // validate and store stock movement of type goods_received
        $v = $r->validate([
            'store_id'=>'required|exists:stores,id',
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|integer|min:1',
            'unit_cost'=>'nullable|numeric'
        ]);
        StockMovement::create([
            'product_id'=>$v['product_id'],
            'store_id'=>$v['store_id'],
            'quantity'=>$v['quantity'],
            'unit_cost'=>$v['unit_cost'] ?? 0,
            'type'=>'goods_received',
            'reference'=>$r->input('reference')
        ]);
        return back()->with('success','Goods recorded');
    }

    public function transfers() { /* show transfer form */ }
    public function storeTransfer(Request $r) { /* logic: create transfer out & transfer in stock_movements */ }

    public function stockTake() {
        $stores = Store::all();
        return view('pos.stock-take', compact('stores'))->with('mode','pos');
    }
    public function storeStockTake(Request $r) { /* store stock take + items */ }
}
