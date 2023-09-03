<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Helpers\AuthHelpers;
use Modules\Products\Entities\Product;

class ProductsController extends Controller
{



    public function show(Request $request, Product $product)
    {
        $keyCheck = AuthHelpers::checkerParamsv1($request);

        if ($keyCheck == 'false') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access'], 401);
        } else if ($keyCheck == 'falseKey') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access, Please check API Param'], 401);
        } else {
            if ($request->id != null) {
                $product = Product::findOrFail($request->id);
                if (!$product) {
                    return response()->json(['error' => 'Product not found'], 404);
                }
            } else {
                return response()->json(['data' => $product]);
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
                'product_group_id' => 'nullable|exists:product_group,id',
                'name' => 'required|string',

                'description' => 'nullable|string',
                'variant' => 'nullable|string',
                'additional_price' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $keyCheck = AuthHelpers::checkerParamsv1($request);

            if ($keyCheck == 'false') {
                return response()->json(['code' => 401, 'message' => 'Unauthorized Access'], 401);
            } else if ($keyCheck == 'falseKey') {
                return response()->json(['code' => 401, 'message' => 'Unauthorized Access, Please check API Param'], 401);
            } else {
                $product = Product::create($request->all());

                return response()->json(['message' => 'Product created successfully', 'data' => $product], 201);
            }
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
        $product = Product::findOrFail($request->id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'product_group_id' => 'nullable|exists:product_group,id',
            'name' => 'required|string',

            'description' => 'nullable|string',
            'variant' => 'nullable|string',
            'additional_price' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $product->update($request->all());

        return response()->json(['message' => 'Product updated successfully', 'data' => $product]);
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
        $product = Product::findOrFail($request->id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
        }
    }
}
