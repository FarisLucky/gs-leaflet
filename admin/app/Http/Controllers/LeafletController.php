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
use Ramsey\Uuid\Uuid;

class LeafletController extends Controller
{
    public function index()
    {
        $leaflets = MLeaflet::all();

        return view("leaflet.index", compact('leaflets'));
    }


    public function store(StoreLeafletRequest $request)
    {
        try {
            MLeaflet::create($request->validated());

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
            DB::beginTransaction();

            $data = MLeaflet::find($id);

            $file = $request->file('upload');
            $name = $data->judul . '_' . Uuid::uuid4();
            $ext = $file->getClientOriginalExtension();
            $path = '/leaflets';
            $fullName = $name . '.' . $ext;

            $files = Storage::disk('public')->putFileAs($path, $file, $fullName);
            $storageUrl = Storage::url($files);
            // $file->storeAs(public_path($path), $fullName);

            $storeFile = MFile::create([
                'name' => $name,
                'ext' => $ext,
                'path' => $path,
                'leaflet_id' => $data->id,
                'url' => $storageUrl,
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

    public function showFile($id)
    {
        try {
            $mFile = MFile::find($id);

            dd(url(Storage::url($mFile->fullUrl)));

            $file = 'storage/' . $mFile->fullUrl;

            return response()->json(['data' => file($file)]);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'FAIL',
                'data' => $th->getMessage(),
            ]);
        }

    }
}
