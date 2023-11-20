<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\SearchLeafletSelectResource;
use App\Models\MFile;
use App\Models\MLeaflet;
use Illuminate\Http\Response;

class LeafletController extends Controller
{

    public function index()
    {
        try {

            $leaflets = MLeaflet::paginate(16);
            // $leaflets = MLeaflet::latest()->get();

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => 'OK',
                'data' => $leaflets,
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

            $files = MFile::where('leaflet_id', $id)->get();

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => 'OK',
                'data' => $files,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'OK',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function showLeaflet($id)
    {

        try {

            $leaflet = MLeaflet::where('id', $id)->get();

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => 'OK',
                'data' => $leaflet,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'OK',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function showLeafletByUnit($unit)
    {

        try {

            $leaflet = MLeaflet::where('unit', $unit)->get();

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => 'OK',
                'data' => $leaflet,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'OK',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function search($name)
    {

        try {

            $leaflets = MLeaflet::search($name)->get();

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => 'OK',
                'data' => SearchLeafletSelectResource::collection($leaflets),
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'OK',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function units()
    {

        try {

            $units = MLeaflet::select('unit')->groupBy('unit')->get();

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
}
