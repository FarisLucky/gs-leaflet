<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeafletRequest;
use App\Http\Requests\UpdateLeafletRequest;
use App\Models\MFile;
use App\Models\MLeaflet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;
use Ramsey\Uuid\Uuid;

class LeafletController extends Controller
{
    public function index()
    {
        $leaflets = MLeaflet::with('mFile')->get();

        $leaflets->transform(function ($val) {
            $val->urlFileJenis = $val->mFile->filter(function ($value, $key) {
                return $value->jenis === 'DOWNLOAD';
            })->first();

            return $val;
        });

        return view("leaflet.index", compact('leaflets'));
    }


    public function store(StoreLeafletRequest $request)
    {
        try {
            $leaflet = MLeaflet::create($request->validated());

            return redirect()->route('leaflets.index')->with(['success' => 'Tindakan Berhasil']);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'status' => 'Tindakan Gagal',
                'msg' => $th->getMessage(),
            ]);
        }

    }

    public function update(UpdateLeafletRequest $request, $id)
    {
        try {
            $leaflet = MLeaflet::find($id);
            $leaflet->update($request->validated());

            return redirect()->route('leaflets.index')->with(['success' => 'Tindakan Berhasil']);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'status' => 'Tindakan Gagal',
                'msg' => $th->getMessage(),
            ]);
        }

    }
    public function uploadFile(Request $request, $id)
    {
        try {

            $jenis = request('jenis');

            DB::beginTransaction();

            $data = MLeaflet::find($id);

            $file = $request->file('upload');
            $name = $data->judul . '_' . Uuid::uuid4();
            $ext = $file->getClientOriginalExtension();
            $path = 'leaflets';
            $fullName = $name . '.' . $ext;

            $files = Storage::disk('public')->putFileAs($path, $file, $fullName);
            $storageUrl = Storage::url($files);

            $storeFile = MFile::create([
                'name' => $name,
                'ext' => $ext,
                'path' => $path,
                'leaflet_id' => $data->id,
                'url' => $storageUrl,
                'jenis' => $jenis,
            ]);

            DB::commit();

            return response()->json([
                'code' => 200,
                'status' => 'OK',
                'data' => $storeFile,
            ]);
        } catch (\Throwable $th) {

            DB::rollback();

            dd($th->getMessage());

            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'FAIL',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function getFile($id)
    {
        $file = MFile::where('leaflet_id', $id)->get();

        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => 'OK',
            'data' => $file
        ]);
    }

    public function showFile($leaflet_id)
    {
        try {
            $mFile = MFile::where('leaflet_id', $leaflet_id)->firstOrFail();

            $file = Storage::path($mFile->fullUrl);

            return response()->file($file, [
                "Content-Type" => "application/pdf",
                "Content-Disposition" => 'inline; filename="' . $mFile->judul . '"'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'FAIL',
                'data' => $th->getMessage(),
            ]);
        }

    }
    public function pdfFile($id)
    {
        try {

            $file = MFile::find($id);

            $storage = Storage::disk('public');

            if ($storage->missing($file->fullUrl)) {
                throw new FileNotFoundException($file->fullUrl);
            }

            return response()->file(Storage::disk('public')->path($file->fullUrl), [
                "Content-Disposition" => "filename='test.jpg'"
            ]);

        } catch (\Throwable $th) {

            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => "FAIl",
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function viewCover($leaflet_id)
    {
        try {
            $leaflet = MLeaflet::with([
                'mFile' => function ($query) {
                    $query->where('jenis', MFile::VIEW);
                }
            ])->findOrFail($leaflet_id);

            $file = Storage::disk('public')->path($leaflet->mFile[0]->fullUrl);

            return response()->file($file);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'FAIL',
                'data' => $th->getMessage(),
            ]);
        }

    }

    public function viewLeaflet($id)
    {
        try {
            $leaflet = MFile::findOrFail($id);

            $file = Storage::disk('public')->path($leaflet->fullUrl);

            return response()->file($file);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'FAIL',
                'data' => $th->getMessage(),
            ]);
        }

    }
}
