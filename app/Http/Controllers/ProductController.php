<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Category;


class ProductController extends Controller
{
    public function getProductPage(){
        return view('product.product');
    }

    public function saveProduct(Request $request){
        $data = $request->all();

        $this->validate($request, [
            'product' => 'required',
            'category' => 'required',
            'supplier' => 'required',
            'quantity' => 'required',
            'price' => 'required'
        ]);
        
        if($data['id'] == 0){
            $product =  Product::create([
                'product' => $data['product'],
                'category_id' => $data['category'],
                'supplier_id' => $data['supplier'],
                'quantity' => $data['quantity'],
                'price' => $data['price'],
            ]);
        }else{
            $product = Product::find($data['id']);
            $product->product = $data['product'];
            $product->category_id = $data['category'];
            $product->supplier_id = $data['supplier'];
            $product->quantity = $data['quantity'];
            $product->price = $data['price'];
            $product->save();
        }

        $statusCode = -1;
    	if($product){
            $statusCode = 0;
    	}
    	$data_response['statusCode'] = $statusCode;
    	$data_response['product'] = $product;

        return $data_response;

    }

    public function getProduct(){
        $product = Product::all();

        $formattedList = array();
        if(count($product) > 0){
            foreach($product as $item){
                $tempArray = array();
                $tempArray['id'] = $item->id;
                $tempArray['product'] = $item->product;
                $tempArray['category'] = $item->category_id;

                $catName = Category::find($item->category_id);
                $tempArray['categoryName'] = $catName['category'];
                $tempArray['supplier'] = $item->supplier_id;

                $supName = Supplier::find($item->supplier_id);
                $tempArray['supplierName'] = $supName['supplier'];
                $tempArray['quantity'] = $item->quantity;
                $tempArray['price'] = $item->price;

                array_push($formattedList , $tempArray);
            }
        }
        
        return $formattedList;
    }

    public function delProduct(Request $request){
        $data = $request->input();
        $flag = false;
        $product = Product::find($data['id']);

    	if($product){
            $product->delete();
            $flag = true;
        }
        
        $statusCode = -1;
    	if($flag){
            $statusCode = 0;
        }
        
    	$data_response['statusCode'] = $statusCode;

    	return $data_response;
    }

}
