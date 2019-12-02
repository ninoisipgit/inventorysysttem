<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Category;

class ReportsController extends Controller
{
    public function getPriceReportPage(){
        return view('reports.pricereport');
    }

    public function getAmountList(){
        $product = Product::all();

        $finalList = array(
            'grand_total_amount'=> 0,
            'grand_total_quantity'=> 0
        );
        if($product){
            foreach($product as $value){
                $supplier = Supplier::find($value->supplier_id);
                $supplierName  = $supplier['supplier'];

	    		if(array_key_exists($supplierName, $finalList)){
	    			$totals = $finalList[$supplierName];
	    		} else {
	    			$totals = array(
	    				"quantity" => 0,
	    				"amount" => 0,
	    				"contact" => $supplier['contact']
	    			);
                }
                $totals['quantity'] += $value->quantity;
                $totals['amount'] += $value->price ;
                
                $finalList[$supplierName] = $totals;
                $finalList['grand_total_amount'] += $value->price;
                $finalList['grand_total_quantity'] += $value->quantity;
            }
        }
        return $finalList;
    }
}
