<?php

namespace App\Http\Controllers;

use App\Models\MUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MUnitController extends Controller
{
    public function index()
    {
        try {
            $units = MUnit::all();

            return view('m_unit.index', compact('units'));
        } catch (\Throwable $th) {
            dd($th);
            abort(404);
        }
    }

    public function store(Request $request)
    {
        try {

            $unit = MUnit::create(['nama' => $request->nama]);

            return redirect()->route('m_unit.index')->with(['success' => 'Tindakan Berhasil']);
        } catch (\Throwable $th) {

            return redirect()->back()->withErrors([
                'status' => 'Tindakan Gagal',
                'msg' => $th->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        try {

            $unit = MUnit::find($id);

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => 'OK',
                'data' => $unit,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'OK',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $unit = MUnit::find($id);
            $unit->update([
                'nama' => $request->nama
            ]);

            return redirect()->route('m_unit.index')->with(['success' => 'Tindakan Berhasil']);

        } catch (\Throwable $th) {

            return redirect()->back()->withErrors([
                'status' => 'Tindakan Gagal',
                'msg' => $th->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        try {

            $unit = MUnit::find($id);
            $unit->delete();
            return redirect()->route('m_unit.index')->with(['success' => 'Tindakan Berhasil']);
        } catch (\Throwable $th) {

            return redirect()->back()->withErrors([
                'status' => 'Tindakan Gagal',
                'msg' => $th->getMessage(),
            ]);
        }
    }
}
