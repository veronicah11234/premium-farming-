<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ItemController extends Controller
{
    public function index()
    {
        $items = Product::all();
        return view('pos.items', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku',
            'category' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);
        

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price
        ]);

        return redirect()->route('items.index')
            ->with('success', 'Item created successfully!');
       
    }
    public function stores()
    {
        $items = Product::all();
        return view('pos.stores', compact('items'));
    }
    
     public function edit($id)
    {
        $item = Item::findOrFail($id);

        return view('pos.edit_item', compact('item'));
    }

    // -------------------------
    // Update item (items.update)
    // -------------------------
    public function update(Request $request, $id)
    {
        $request->validate([
            'sku'   => 'required',
            'name'  => 'required',
            'price' => 'required|numeric'
        ]);

        $item = Item::findOrFail($id);

        $item->update([
            'sku'   => $request->sku,
            'name'  => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('items.index')->with('success', 'Item updated successfully!');
    }

    // -------------------------
    // Delete item (items.destroy)
    // -------------------------
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item removed successfully!');
    }



}
