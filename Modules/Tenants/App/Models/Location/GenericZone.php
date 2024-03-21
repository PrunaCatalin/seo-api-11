<?php

namespace Modules\Tenants\App\Models\Location;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GenericZone extends Model
{
    use HasFactory;

    protected $table = 'generic_zones';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_city',
        'name',
        'longitude',
        'latitude',
        'region',
    ];

    public function city()
    {
        return $this->belongsTo(GenericCity::class, 'id_city');
    }
}
