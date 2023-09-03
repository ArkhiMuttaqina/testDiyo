<?php

namespace Modules\Presences\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Presences\Entities\Presences;
use Modules\Presences\Http\Requests\PresenceRequest;



class PresencesController extends Controller
{
    /**
     * @OA\post(
     *     path="/presences/checklog",
     *     tags={"/presences/checklog"},
     *     summary="Returns a Sample API response",
     *     description="API untuk checklog karyawan",
     *     operationId="checklog",
     *     @OA\Parameter(
     *          name="type",
     *          description="tipe check log",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
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
        return view('presences::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('presences::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param PresenceRequest $request
     * @return Renderable
     */
    public function store(PresenceRequest $request)
    {
        $presence = new Presences();
        $presence->type = $request->input('type');
        $presence->user_id = auth()->user()->id;
        // $presence->datetime = Carbon::now();
        $presence->save();

        return response()->json(['message' => 'Presence recorded successfully']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('presences::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('presences::edit');
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
