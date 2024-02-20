<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MUnitController extends Controller
{
    public function index()
    {
        try {

            $units = MUnit::all();

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => 'OK',
                'data' => $units,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'OK',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        try {

            $unit = MUnit::create(['nama' => $request->nama]);

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

    public function destroy($id)
    {
        try {

            $unit = MUnit::find($id);
            $unit->delete();

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
}
