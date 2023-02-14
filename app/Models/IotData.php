<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class IotData
 * @property int $id
 * @property string|null $sensor_code
 * @property int|null $tipo_dato_id
 * @property float|null $value
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property ItemCatalogo|null $item_catalogo
 * @package App\Models
 */
class IotData extends Model
{
    use SoftDeletes;
    protected $table = 'iot_data';

    public $timestamps = true;

    protected $casts = [
        'tipo_dato_id' => 'int',
        'value' => 'float'
    ];

    protected $fillable = [
        'sensor_code',
        'tipo_dato_id',
        'value'
    ];

    public function item_catalogo()
    {
        return $this->belongsTo(ItemCatalogo::class, 'tipo_dato_id');
    }
}
