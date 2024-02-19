<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class MFile extends Model
{
    const VIEW = 'VIEW';
    const DOWNLOAD = 'DOWNLOAD';
    protected $table = 'm_file';
    protected $primaryKey = 'id';
    protected $fillable = [
        'leaflet_id',
        'name',
        'jenis',
        'ext',
        'path',
        'url',
        'order',
    ];
    protected $appends = ['fullUrl', 'urlFile'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function delete()
    {

        $hasFile = Storage::disk('public')->exists($this->fullUrl);

        if ($hasFile) {
            Storage::disk('public')->delete($this->fullUrl);
        }

        return parent::delete();
    }

    public function getFullUrlAttribute()
    {
        return $this->path . '/' . $this->name . '.' . $this->ext;
    }

    public function getUrlFileAttribute()
    {
        return Storage::disk('public')->url($this->path . '/' . $this->name . '.' . $this->ext);
    }

    public function getUrlFileJenisAttribute()
    {
        if ($this->jenis === 'DOWNLOAD') {
            return url($this->url);
        }

        return false;
    }

    public function getCreatedAtAttribute($value)
    {
        return !is_null($value) ? Carbon::make($value)->format('Y-m-d H:i') : $value;
    }

    public function mLeaflet(): BelongsTo
    {
        return $this->belongsTo(MLeaflet::class, 'leaflet_id', 'id');
    }
}
