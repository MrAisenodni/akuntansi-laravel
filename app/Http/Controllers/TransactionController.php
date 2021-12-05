<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function __construct() {
        $this->transaction = new Transaction();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction = $this->transaction::where('disabled', 0)->orderBy('created_at', 'DESC')->get();

        $response = [
            'message'       => 'Daftar Transaksi',
            'data'          => $transaction,
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'amount'        => 'required|numeric',
            'type'          => 'required|in:expense,revenue,liability',
            'disabled'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $transaction = $this->transaction::create($request->all());
            $response = [
                'message'       => 'Transaksi berhasil ditambahkan.',
                'data'          => $transaction,
            ];

            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message'       => "Failed " . $e->erroInfo,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = $this->transaction::findOrFail($id);

        $response = [
            'message'       => 'Daftar Transaksi',
            'data'          => $transaction,
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transaction = $this->transaction::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title'         => 'required',
            'amount'        => 'required|numeric',
            'type'          => 'required|in:expense,revenue,liability',
            'disabled'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $transaction->update($request->all());
            $response = [
                'message'       => 'Transaksi berhasil diubah.',
                'data'          => $transaction,
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message'       => "Failed " . $e->erroInfo,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = $this->transaction::findOrFail($id);

        try {
            $transaction->delete();
            $response = [
                'message'       => 'Transaksi berhasil dihapus.',
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message'       => "Failed " . $e->erroInfo,
            ]);
        }
    }
}
