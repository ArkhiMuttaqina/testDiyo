<?php

namespace Modules\Payslips\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payslips\Http\Controllers\utils\PaySlipUtilitiesController;
use Modules\Payslips\Http\Requests\PayslipsRequest;

/**
 * @OA\Info(title="Backend Kledo", version="0.1")
 *
 */
class PayslipsController extends Controller
{

    /**
     * \
     *
     * @OA\post(
     *     path="/payslips/summary",
     *     tags={"api/payslips/summary"},
     *     summary="Returns a Sample API response",
     *     description="API untuk checklog karyawan",
     *     operationId="checklog",
     *     @OA\Parameter(
     *          name="month",
     *          description="bulan dengan format MM / interger",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="Integer"
     *          )
     *     )
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('payslips::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('payslips::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(PayslipsRequest $request, PaySlipUtilitiesController $utils)
    {
        $paySlipData = $utils->generatePaySlip($request->input('month'));
        return response()->json($paySlipData);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('payslips::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
