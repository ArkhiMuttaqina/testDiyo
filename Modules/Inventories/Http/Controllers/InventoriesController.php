<?php

namespace Modules\Inventories\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Helpers\AuthHelpers;
use Modules\Inventories\Entities\Inventory;

class InventoriesController extends Controller
{
    public function index()
    {
        return Inventory::all();
    }

    public function show(Request $request, Inventory $inventory)
    {

        $keyCheck = AuthHelpers::checkerParamsv1($request);


        if($keyCheck == 'false'){
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access'], 401);
        }else if($keyCheck == 'falseKey'){
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access, Please check API Param'], 401);
        }else{
            if($request->id != null){
                $inventory = Inventory::findOrFail($request->id);
                if (!$inventory) {
                    return response()->json(['error' => 'Product not found'], 404);
                }
                return response()->json(['data' => $inventory]);
            }else{
                return response()->json(['data' => $inventory]);
            }

        }
    }




    public function store(Request $request)
    {
        $keyCheck = AuthHelpers::checkerParamsv1($request);

        if ($keyCheck == 'false') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access'], 401);
        } else if ($keyCheck == 'falseKey') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access, Please check API Param'], 401);
        } else {
            $validator = Validator::make($request->all(), [
                'product_id' => 'nullable|exists:products,id',
                'name' => 'required|string',
                'price' => 'nullable|string',
                'sku' => 'nullable|string',
                'amount' => 'nullable|string',
                'unit' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $inventory = Inventory::create($request->all());

            return response()->json(['message' => 'Inventory created successfully', 'data' => $inventory], 201);
        }

    }

    public function update(Request $request)
    {
        $keyCheck = AuthHelpers::checkerParamsv1($request);

        if ($keyCheck == 'false') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access'], 401);
        } else if ($keyCheck == 'falseKey') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access, Please check API Param'], 401);
        } else {
            $inventory = Inventory::findOrFail($request->id);

            if (!$inventory) {
                return response()->json(['error' => 'Inventory not found'], 404);
            }

            $validator = Validator::make($request->all(), [
                'product_id' => 'nullable|exists:products,id',
                'name' => 'required|string',
                'price' => 'nullable|string',
                'sku' => 'nullable|string',
                'amount' => 'nullable|string',
                'unit' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $inventory->update($request->all());

            return response()->json(['message' => 'Inventory updated successfully', 'data' => $inventory]);
        }

    }

    public function destroy(Request $request)
    {
        $keyCheck = AuthHelpers::checkerParamsv1($request);

        if ($keyCheck == 'false') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access'], 401);
        } else if ($keyCheck == 'falseKey') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access, Please check API Param'], 401);
        } else {
            $product = Inventory::findOrFail($request->id);

            if (!$product) {
                return response()->json(['error' => 'Inventory not found'], 404);
            }

            $product->delete();

            return response()->json(['message' => 'Product deleted successfully']);
        }

    }
}
