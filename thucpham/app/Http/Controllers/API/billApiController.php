<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\donhang;
use Illuminate\Http\Response;

class billApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(donhang::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $bill = donhang::create($request->all());

        return response()->json($bill, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $bill = donhang::find($id);
        if (is_null($bill)) {
            return response()->json(['Not Found', 404]);
        }
        return response()->json($bill, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */

    public function update(Request $request, $id)
    {


        $bill = donhang::find($id);
        if (is_null($bill)) {
            return response()->json(["message" => "Not found"], 404);
        }

        $bill->update($request->all());

        if ((int)$request->input('loaidon') == 3) {
            date_default_timezone_set('Asia/Bangkok');
            $date = date('Y/m/d H:i:s');
            $year = substr($date,0,4);
            $yearN = (int) $year + 1;
            $date=str_replace($year,$yearN,$date);
            $bill = donhang::create([
                'idnhanvien' => 1,
                'idkhachhang' => (int)$request->input('idkhachhang'),
                'tongtien' => 0,
                'loaidon' => 1,
                'thoigian'=> $date,
                'thanhtoan' => 0
            ]);
            return response()->json($bill, 200);
        }


        return response()->json($bill, 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $bill = donhang::find($id);
        if (is_null($bill)) {
            return response()->json(["message" => "Not found"], 404);
        }
        $bill->delete();
        return response()->json(null, 200);
    }

    public function getByIDCustomer($idkhachhang)
    {
        return donhang::where('idkhachhang', $idkhachhang)->get();
    }

    public function getProductByBillId($id)
    {
        $m = new donhang();
        $order = $m->getOderDetail($id);
        return $order;
    }
}
