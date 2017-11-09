<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {	
    	return view('product.index');
    }
     public function show()
    {
        Session::put('product_search', Input::has('ok') ? Input::get('search') : (Session::has('product_search') ? Session::get('product_search') : ''));
        Session::put('product_field', Input::has('field') ? Input::get('field') : (Session::has('product_field') ? Session::get('product_field') : 'name'));
        Session::put('product_sort', Input::has('sort') ? Input::get('sort') : (Session::has('product_sort') ? Session::get('product_sort') : 'asc'));
        $products = Product::where('name', 'like', '%' . Session::get('product_search') . '%')
            ->orderBy(Session::get('product_field'), Session::get('product_sort'))->paginate(8);
        return view('product.list', ['products' => $products]);
    }

    public function edit($id)
    {
        return view('product.update', ['product' => Product::find($id)]);
    }

    public function update($id)
    {
        $product = Product::find($id);
        $rules = ["unitprice" => "required|numeric"];
        if ($product->name != Input::get('name'))
            $rules += ['name' => 'required|unique:products'];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            );
        }
        $product->name = Input::get('name');
        $product->unitprice = Input::get('unitprice');
        $product->save();
        return ['url' => 'product/list'];
    }

    public function create()
    {
        return view('product.create');
    }

    public function store()
    {
        $validator = Validator::make(Input::all(), [
            "name" => "required|unique:products",
            "unitprice" => "required|numeric"
        ]);
        if ($validator->fails()) {
            return array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            );
        }
        $product = new Product();
        $product->name = Input::get('name');
        $product->unitprice = Input::get('unitprice');
        $product->save();
        return ['url' => 'product/list'];
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return Redirect('product/list');
    }


}
