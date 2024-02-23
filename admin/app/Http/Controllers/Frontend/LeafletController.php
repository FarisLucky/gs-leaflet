<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\SearchLeafletSelectResource;
use App\Models\MFile;
use App\Models\MLeaflet;
use App\Models\MUnit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class LeafletController extends Controller
{

    public function index()
    {
        try {

            $search = request('q');

            $leaflets = MLeaflet::with([
                'mFile',
                'mCover' => function ($query) {
                    $query->where('jenis', MFile::VIEW)->where('order', 0);
                }
            ]);

            $leaflets->when(isset($search) && $search !== '', function($query) use ($search){
                $query->search($search);
            });

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => 'OK',
                'data' => $leaflets->paginate(8),
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'OK',
                'data' => $th->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {

        try {

            $files = MFile::where(function ($query) use ($id) {
                $query->where('leaflet_id', $id)
                    ->where('jenis', MFile::VIEW)
                    ->where('order', '<>', 0);
            })->get();

            if ($files->isEmpty()) {
                throw new ModelNotFoundException('LEAFLET BELUM TERSEDIA');
            }

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => 'OK',
                'data' => $files,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'code' => $th->getCode(),
                'status' => $th->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    public function showLeaflet($id)
    {

        try {

            $leaflet = MLeaflet::with('mFile')->where('id', $id)->paginate(8);

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

            $leaflet = MLeaflet::with('mFile')->where('unit', $unit)->paginate(8);

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

    public function search()
    {

        try {

            $search = request('q');

            $leaflets = MLeaflet::with('mFile')->search($search)->paginate(8);

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

            $units = MUnit::pluck('nama');

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

            $file = Storage::disk('public')->path($leaflet->mFile[0]->fullUrl);

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
