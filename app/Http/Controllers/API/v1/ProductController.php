<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index() {
        $products = Product::where('is_active',1)->get();
        return $this->apiResponseResourceCollection(200,'Products List',ProductResource::collection($products));
    }
    public function checkout(Request $request){
        $validate = $request->validate([
            'total' => 'required|numeric',
            'sub_total' => 'required|numeric',
            'discount' => 'required|numeric',
            'items' => 'required|array',
        ]);
        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total' => $validate['total'],
                'sub_total' => $validate['sub_total'],
                'discount' => $validate['discount'],
            ]);
            foreach ($validate['items'] as $item) {
                $product = Product::find($item['product']['id']);
                if ($product->stock >= $item['quantity']) {
                    $sale->saleProducts()->create([
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'total' => $item['quantity'] * $product->price,
                    ]);
                    $product->decrement('stock', $item['quantity']);
                }
                
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(500, 'An error occurred while processing your request', $e->getMessage());
        }

        return $this->apiResponse(200, 'success','Checkout successful');
    }
}
