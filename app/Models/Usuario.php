<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Usuario
 * 
 * @property int $id
 * @property int $persona_id
 * @property string $username
 * @property string $password
 * @property bool|null $accede_panel_administracion
 * @property int|null $numero_logins
 * @property bool|null $usuario_validado
 * @property bool|null $solo_lectura
 * @property Carbon|null $ultima_fecha_acceso
 * @property int|null $rol_principal_id
 * @property int|null $sitio_principal_id
 * @property string|null $selector
 * @property bool|null $enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Persona $persona
 * @property Rol|null $rol
 * @property Sitio|null $sitio
 * @property Collection|Pedido[] $pedidos
 * @property Collection|UsuarioRecurso[] $usuario_recursos
 * @property Collection|Rol[] $rols
 * @property Collection|Sitio[] $sitios
 *
 * @package App\Models
 */
class Usuario extends Model
{
    use SoftDeletes;
    protected $table = 'usuario';

    protected $casts = [
        'persona_id' => 'int',
        'accede_panel_administracion' => 'bool',
        'numero_logins' => 'int',
        'usuario_validado' => 'bool',
        'solo_lectura' => 'bool',
        'rol_principal_id' => 'int',
        'sitio_principal_id' => 'int',
        'enabled' => 'bool'
    ];

    protected $dates = [
        'ultima_fecha_acceso'
    ];

    protected $hidden = [
        'password'
    ];

    protected $fillable = [
        'persona_id',
        'username',
        'password',
        'accede_panel_administracion',
        'numero_logins',
        'usuario_validado',
        'solo_lectura',
        'ultima_fecha_acceso',
        'rol_principal_id',
        'sitio_principal_id',
        'selector',
        'enabled'
    ];

    public static function getUserByUsername($username)
    {
        $userLogin = Usuario::query()
            ->select('usuario.id', 'usuario.username', 'usuario.password', 'usuario.numero_logins', 'usuario.enabled', 'usuario.accede_panel_administracion', 'usuario.rol_principal_id', 'usuario.selector', 'usuario.sitio_principal_id', 'persona.id as persona_id', 'persona.nombres as persona_nombres', 'persona.apellidos as persona_apellidos', 'persona.identificacion', 'sitio.nombre as sitio_nombre', 'sitio.selector as sitio_selector', 'rol.nombre as rol_nombre')
            ->join('persona', 'usuario.persona_id', '=', 'persona.id')
            ->leftJoin('sitio', 'usuario.sitio_principal_id', '=', 'sitio.id')
            ->leftJoin('rol', 'usuario.rol_principal_id', '=', 'rol.id')
            ->where('usuario.username', $username)
            ->first();
        return $userLogin;
    }

    public static function updateUserAccessById($userId)
    {
        $user = Usuario::find($userId);
        if (isset($user)) {
            $user->numero_logins = $user->numero_logins + 1;
            $user->ultima_fecha_acceso = Carbon::now();
            $user->save();
        }
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_principal_id');
    }

    public function sitio()
    {
        return $this->belongsTo(Sitio::class, 'sitio_principal_id');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function usuario_recursos()
    {
        return $this->hasMany(UsuarioRecurso::class);
    }

    public function rols()
    {
        return $this->belongsToMany(Rol::class, 'usuario_rol')
            ->withPivot('id', 'predeterminado', 'deleted_at')
            ->withTimestamps();
    }

    public function sitios()
    {
        return $this->belongsToMany(Sitio::class, 'usuario_sitio')
            ->withPivot('id', 'predeterminado', 'deleted_at')
            ->withTimestamps();
    }
}
