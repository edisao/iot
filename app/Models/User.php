<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Model implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['persona_id', 'rol_principal_id', 'sitio_principal_id', 'username', 'password', 'accede_panel_administracion', 'numero_logins', 'usuario_validado', 'codigo_validacion', 'solo_lectura', 'administrador', 'ultima_fecha_acceso', 'selector', 'enabled', 'remember_token'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        //'password',
        //'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];

    public static function getUserByUsername($username)
    {
        $userLogin = User::query()
            ->select('usuario.id', 'usuario.username', 'usuario.password', 'usuario.numero_logins', 'usuario.enabled', 'usuario.accede_panel_administracion', 'usuario.rol_principal_id', 'usuario.selector', 'usuario.sitio_principal_id', 'persona.id as persona_id', 'persona.nombres as persona_nombres', 'persona.apellidos as persona_apellidos', 'persona.identificacion', 'persona.mail_principal', 'sitio.codigo as sitio_codigo', 'sitio.nombre as sitio_nombre', 'sitio.selector as sitio_selector', 'rol.nombre as rol_nombre', 'persona.imagen_avatar')
            ->join('persona', 'usuario.persona_id', '=', 'persona.id')
            ->leftJoin('sitio', 'usuario.sitio_principal_id', '=', 'sitio.id')
            ->leftJoin('rol', 'usuario.rol_principal_id', '=', 'rol.id')
            ->where('usuario.username', $username)
            ->first();
        return $userLogin;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        //return [];
        return [
            'id'              => $this->id,
            'first_name'      => $this->persona_nombres,
            'last_name'       => $this->persona_apellidos,
            'email'           => $this->mail_principal,
            'selector'        => $this->selector,
            'rol'             => $this->rol_principal_id,
            'sitio'           => $this->sitio_codigo,
            //'registered_at'   => $this->created_at->toIso8601String(),
            //'last_updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
