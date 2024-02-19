<?php

namespace App\Models;

use App\Models\Traits\FullTextSearch;
use Illuminate\Database\Eloquent\Model;

class MLeaflet extends Model
{
    use FullTextSearch;
    protected $table = 'm_leaflet';
    protected $primaryKey = 'id';
    protected $fillable = [
        'judul',
        'desc',
        'id_unit',
        'unit',
    ];

    protected $appends = ['disp_txt'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $searchable = [
        'judul',
        'desc',
        'unit',
    ];

    public function getDispTxtAttribute()
    {
        return $this->judul . ' - ' . $this->unit;
    }

    public function mFile()
    {
        return $this->hasMany(MFile::class, 'leaflet_id', 'id');
    }

    public function delete()
    {
        $this->mFile()->delete();

        return parent::delete();
    }
}
