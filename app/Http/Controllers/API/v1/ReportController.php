<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DateSalesResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductSalesResource;
use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
class ReportController extends Controller
{

    public function dateWiseSalesReport()
    {
        $start_date = request()->query('start_date');
        $end_date = request()->query('end_date');

        $sales = Sale::query()->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            $query->where('created_at', '>=', $start_date)
                  ->where('created_at', '<=', $end_date);
        })->with('saleProducts', 'user');

        $sales = $sales->get();
        return $this->apiResponseResourceCollection(200, 'Date wise sales report',DateSalesResource::collection($sales));
    }

    public function productWiseSalesReport()
    {
        $start_date = request()->query('start_date');
        $end_date = request()->query('end_date');

        $salesQuery = Sale::with('saleProducts.product')
            ->select('id') 
            ->withSum('saleProducts as total_quantity', 'quantity')
            ->withSum('saleProducts as total_sales', 'total');

        if ($start_date && $end_date) {
            $salesQuery->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date);
        }

        $sales = $salesQuery->get();

        $result = $sales->flatMap(function ($sale) {
            return $sale->saleProducts->map(function ($saleProduct) {
                return [
                    'name' => $saleProduct->product->name,
                    'total_quantity' => $saleProduct->quantity,
                    'total_sales' => $saleProduct->total,
                ];
            });
        })->groupBy('name')->map(function ($group) {
            return [
                'name' => $group->first()['name'],
                'total_quantity' => $group->sum('total_quantity'),
                'total_sales' => $group->sum('total_sales'),
            ];
        })->values()->toArray();

        return $this->apiResponseResourceCollection(200, 'Product
        wise sales report', ProductSalesResource::collection($result));
    }

    public function productWiseStockReport()
    {
        $products = Product::all();

        return $this->apiResponseResourceCollection(200, 'Product wise stock report', ProductResource::collection($products));
    }
}

