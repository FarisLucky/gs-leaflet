<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\SearchLeafletSelectResource;
use App\Models\MFile;
use App\Models\MLeaflet;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class LeafletController extends Controller
{

    public function index()
    {
        try {

            $leaflets = MLeaflet::with('mFile')->paginate(10);

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

            $files = MFile::where(function ($query) use ($id) {
                $query->where('leaflet_id', $id)->where('jenis', MFile::VIEW);
            })->get();

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

            $leaflet = MLeaflet::with('mFile')->where('id', $id)->paginate(16);

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

            $leaflet = MLeaflet::with('mFile')->where('unit', $unit)->paginate(16);

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

            $leaflets = MLeaflet::with('mFile')->search($name)->paginate(16);

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

    public function download($leaflet_id)
    {
        try {
            $leaflet = MLeaflet::with([
                'mFile' => function ($query) {
                    $query->where('jenis', MFile::DOWNLOAD);
                }
            ])
                ->findOrFail($leaflet_id);

            $file = Storage::path($leaflet->mFile[0]->fullUrl);

            return response()->download($file, $leaflet->judul . '.' . '.pdf');
        } catch (\Throwable $th) {
            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'FAIL',
                'data' => $th->getMessage(),
            ]);
        }

    }

}
