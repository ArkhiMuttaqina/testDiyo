<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Helpers\AuthHelpers;
use Modules\Sales\Entities\Sales;

class SalesController extends Controller
{


    public function show(Request $request, Sales $sales)
    {


        $keyCheck = AuthHelpers::checkerParamsv1($request);
        if ($keyCheck == 'false') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access'], 401);
        } else if ($keyCheck == 'falseKey') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access, Please check API Param'], 401);
        } else {
            if ($request->id != null) {
                $sales = Sales::findOrFail($request->id);
                if (!$sales) {
                    return response()->json(['error' => 'Sales not found'], 404);
                }
            } else {
                return response()->json(['data' => $sales]);
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
            'sales_id' => 'required|string',
            'total_price' => 'required|integer|min:0',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $sale = Sales::create($request->all());

        return response()->json(['message' => 'Sales created successfully', 'data' => $sale], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $keyCheck = AuthHelpers::checkerParamsv1($request);
        if ($keyCheck == 'false') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access'], 401);
        } else if ($keyCheck == 'falseKey') {
            return response()->json(['code' => 401, 'message' => 'Unauthorized Access, Please check API Param'], 401);
        } else {
        $sale = Sales::findOrFail($id);

        if (!$sale) {
            return response()->json(['error' => 'Sales not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'sales_id' => 'required|string',
            'total_price' => 'required|integer|min:0',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $sale->update($request->all());

        return response()->json(['message' => 'Sales updated successfully', 'data' => $sale]);
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
        $sale = Sales::findOrFail($request->id);

        if (!$sale) {
            return response()->json(['error' => 'Sales not found'], 404);
        }

        $sale->delete();

        return response()->json(['message' => 'Sales deleted successfully']);
        }
    }
}
