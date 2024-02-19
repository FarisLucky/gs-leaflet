<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MFile;
use App\Models\MLeaflet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LeafletController extends Controller
{
    public function index()
    {
        $leaflets = MLeaflet::with('mFile')->get();

        return response()->json([
            'code' => 200,
            'status' => 'OK',
            'data' => $leaflets,
        ]);
    }

    public function dataFile($idLeaflet)
    {
        $file = MFile::where(function ($query) use ($idLeaflet) {
            $query->where('leaflet_id', $idLeaflet)->where('jenis', MFile::VIEW);
        });

        return DataTables::of($file)
            ->addIndexColumn()
            ->editColumn('order', function ($l) {
                return '<input type="number" class="form-control form-control-sm updateOrder" value="' . $l->order . '" data-url="' . route("api.leaflet.update_order", ['id' => $l->id]) . '" />';
            })
            ->addColumn('aksi', function ($l) {
                // $html = '<a href="#" class="btn btn-sm btn-outline-info edit-gDietPasien"><i class="fas fa-edit py-1"></i></a>';
                $html = '
                <a href="' . route('pdf_file', ['id' => $l->id]) . '" target="_blank"><i class="ti ti-eye mb-1 text-info"></i></a>
                <a href="' . url($l->url) . '" class="edit"><i class="ti ti-pencil mb-1"></i></a>
                <a href="' . route("api.leaflet.destroy_order", ['id' => $l->id]) . '" class="hapus link-danger"><i class="ti ti-trash mb-1"></i></a>';

                return $html;
            })
            ->rawColumns(['aksi', 'order'])
            ->make(true);
    }

    public function updateOrder(Request $request, $id)
    {
        try {

            $file = MFile::find($id);

            $file->update([
                'order' => $request->order
            ]);

            return response()->json([
                'code' => Response::HTTP_OK,
                'status' => "OK",
                'data' => $file,
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => "FAIl",
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function destroyOrder($id)
    {
        try {

            $file = MFile::find($id);

            $file->delete();

            return response()->json([
                'code' => Response::HTTP_NO_CONTENT,
                'status' => "OK",
                'data' => $file,
            ]);

        } catch (\Throwable $th) {

            DB::rollBack();

            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => "FAIl",
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $leaflet = MLeaflet::find($id);

            $leaflet->delete();

            DB::commit();
            return response()->json([
                'code' => Response::HTTP_NO_CONTENT,
                'status' => "OK",
                'data' => $leaflet,
            ]);

        } catch (\Throwable $th) {

            DB::rollBack();
            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => "FAIl",
                'data' => $th->getMessage(),
            ]);
        }
    }
}
