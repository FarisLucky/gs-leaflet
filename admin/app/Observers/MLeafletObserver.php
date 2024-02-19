<?php

namespace App\Observers;

use App\Models\MLeaflet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MLeafletObserver
{
    /**
     * Handle the MLeaflet "created" event.
     *
     * @param  \App\Models\MLeaflet  $mLeaflet
     * @return void
     */
    public function created(MLeaflet $mLeaflet)
    {
        //
    }

    /**
     * Handle the MLeaflet "updated" event.
     *
     * @param  \App\Models\MLeaflet  $mLeaflet
     * @return void
     */
    public function updated(MLeaflet $mLeaflet)
    {
        //
    }

    /**
     * Handle the MLeaflet "deleted" event.
     *
     * @param  \App\Models\MLeaflet  $mLeaflet
     * @return void
     */
    public function deleted(MLeaflet $mLeaflet)
    {
        DB::beginTransaction();

        $mLeaflet->mFile->each(function ($file) {
            // Hapus File
            try {
                Storage::delete($file->fullUrl);

                // Hapus File
                $file->delete();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        });

        DB::commit();
    }

    /**
     * Handle the MLeaflet "restored" event.
     *
     * @param  \App\Models\MLeaflet  $mLeaflet
     * @return void
     */
    public function restored(MLeaflet $mLeaflet)
    {
        //
    }

    /**
     * Handle the MLeaflet "force deleted" event.
     *
     * @param  \App\Models\MLeaflet  $mLeaflet
     * @return void
     */
    public function forceDeleted(MLeaflet $mLeaflet)
    {
        //
    }
}
