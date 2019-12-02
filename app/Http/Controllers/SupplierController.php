<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function getSupplierPage(){
        return view('supplier.supplier');
    }

    public function saveSupplier(Request $request){
        $data = $request->all();
        if($data['id'] == 0){
            $this->validate($request, [
                'contact' => 'required|unique:suppliers',
                'supplier' => 'required|unique:suppliers'
            ]);

            $supplier =  Supplier::create([
                'supplier' => $data['supplier'],
                'contact' => $data['contact'],
            ]);
        }else{
            $this->validate($request, [
                'supplier' => [
                    'required',
                    Rule::unique('suppliers')->ignore($data['id']),
                ],
                'contact' => [
                    'required',
                    Rule::unique('suppliers')->ignore($data['id']),
                ],
            ]);
            $supplier = Supplier::find($data['id']);
            $supplier->supplier = $data['supplier'];
            $supplier->contact = $data['contact'];
            $supplier->save();
        }


        $statusCode = -1;
    	if($supplier){
            $statusCode = 0;
    	}
    	$data_response['statusCode'] = $statusCode;
    	$data_response['supplier'] = $supplier;

        return $data_response;
    }

    public function getSupplier(){
        $supplier = Supplier::all();
        
        $formattedList = array();
        if(count($supplier) > 0){
            foreach($supplier as $item){
                $tempArray = array();
                $tempArray['id'] = $item->id;
                $tempArray['supplier'] = $item->supplier;
                $tempArray['contact'] = $item->contact;

                array_push($formattedList , $tempArray);
            }
        }

        return $formattedList;
    }

    public function delSupplier(Request $request){
        $data = $request->input();
        $flag = false;
        $supplier = Supplier::find($data['id']);

    	if($supplier){
            $supplier->delete();
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
