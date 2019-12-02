<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function getCategoryPage(){
        return view('category.category');
    }

    public function saveCategory(Request $request){
        $data = $request->all();
        
        if($data['id'] == 0){
            $this->validate($request, [
                'category' => 'required|unique:categories'
            ]);
            $category =  Category::create([
                'category' => $data['category'],
            ]);
        }else{
            $this->validate($request, [
                'category' => [
                    'required',
                    Rule::unique('categories')->ignore($data['id']),
                ],
            ]);
            $category = Category::find($data['id']);
            $category->category = $data['category'];
            $category->save();
        }


        $statusCode = -1;
    	if($category){
            $statusCode = 0;
    	}
    	$data_response['statusCode'] = $statusCode;
    	$data_response['category'] = $category;

        return $data_response;
    }

    public function getCategory(){
        $category = Category::all();
        
        $formattedList = array();
        if(count($category) > 0){
            foreach($category as $item){
                $tempArray = array();
                $tempArray['id'] = $item->id;
                $tempArray['name'] = $item->category;
                array_push($formattedList , $tempArray);
            }
        }

        return $formattedList;
    }

    public function delCategory(Request $request){
        $data = $request->input();
        $flag = false;
        $category = Category::find($data['id']);

    	if($category){
            $category->delete();
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
