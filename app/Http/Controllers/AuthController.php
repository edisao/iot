<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Helpers\Constants;
use App\Libraries\AuthUtil;
use App\Models\{Usuario, User, Parametro};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthController extends ApiController
{
    protected $constants;

    public function __construct()
    {
        $this->constants = new Constants();
    }

    public function index()
    {
        $errorMessage = '';
        if (session()->exists($this->constants->sessionErrorLogin)) {
            $errorMessage = session($this->constants->sessionErrorLogin);
            session()->forget($this->constants->sessionErrorLogin);
        }

        return view('login')->with('errorMessage', $errorMessage);
    }

    public function login(Request $request)
    {
        $numeroLogins = 0;
        $userId = 0;
        $personId = 0;
        $rolPrincipalId = 0;
        $sitioPrincipalId = 0;
        $nombres = "";
        $apellidos = "";
        $mailPrincipal = "";
        $rolPrincipal = "";
        $sitioPrincipal = "";
        $imagenAvatar = '';
        $selector = '';

        try {
            $validator = Validator::make($request->all(), [
                'Username' => 'required',
                'Password' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('login')
                    ->withErrors($validator)
                    ->withInput();
            }

            $resultCode = 8;
            $resultDescription = "ERROR";
            $username = trim($request->Username);
            $password = trim($request->Password);
            $userLogin = Usuario::getUserByUsername($username);

            if (isset($userLogin)) {
                $userId = $userLogin->id;
                if (password_verify($password, $userLogin->password)) {
                    if ($userLogin->enabled) {
                        if ($userLogin->accede_panel_administracion) {
                            if (isset($userLogin->rol_principal_id)) {
                                if (isset($userLogin->sitio_principal_id)) {
                                    $personId = $userLogin->persona_id;
                                    $rolPrincipalId = $userLogin->rol_principal_id;
                                    $sitioPrincipalId = $userLogin->sitio_principal_id;
                                    $nombres = $userLogin->persona_nombres;
                                    $apellidos = $userLogin->persona_apellidos;
                                    $mailPrincipal = $userLogin->mail_principal;
                                    $rolPrincipal = $userLogin->rol_nombre;
                                    $sitioPrincipal = $userLogin->sitio_nombre;
                                    $sitioSelector = $userLogin->sitio_selector;
                                    //$imagenAvatar = $userLogin->imagen_avatar;
                                    $selector = $userLogin->selector;
                                    // Usuario validado correctamente
                                    // puede acceder al sitio
                                    $resultCode = 0;
                                    $resultDescription = trans('msg.msgUsuarioLoginOk');
                                } else {
                                    $resultCode = 7;
                                    $resultDescription = trans('msg.errUsuarioSinSitio');
                                }
                            } else {
                                $resultCode = 6;
                                $resultDescription = trans('msg.errUsuarioSinRol');
                            }
                        } else {
                            $resultCode = 4;
                            $resultDescription = trans('msg.errUsuarioSinAcceso');
                        }
                    } else {
                        $resultCode = 3;
                        $resultDescription = trans('msg.errUsuarioInactivo');
                    }
                } else {
                    $resultCode = 2;
                    $resultDescription = trans('msg.errUsuarioPasswordIncorrecto');
                }
            } else {
                $requestDenied = json_encode($request->all());
                Log::critical("USERNAME: " . $request->Username . '. PASSWORD: ' . $request->Password . '. IP: ' . $request->ip() . '. REQUEST: ' . $requestDenied);
                // Username no existe
                $resultCode = 1;
                $resultDescription = trans('msg.errUsuarioNoExiste');
            }
            //return $resultCode . ' ' . $resultDescription;
            if ($resultCode == 0) {
                $updateUserAccess = Usuario::updateUserAccessById($userId);
                $timeoutSession = (!empty(Config::get('microtess.authentication.timeout')) ? Config::get('microtess.authentication.timeout') : "90");
                //$request()->session()->regenerate();

                $currentDate = Carbon::now();
                $expirationDate = Carbon::now()->addMinutes($timeoutSession);
                $serviceContext = array(
                    $this->constants->contextSessionId => (string) Str::uuid(),
                    $this->constants->contextUserId => $userId,
                    $this->constants->contextPersonId => $personId,
                    $this->constants->contextRolId => $rolPrincipalId,
                    $this->constants->contextSitioId => $sitioPrincipalId,
                    $this->constants->contextSitioSelector => $sitioSelector,
                    $this->constants->contextRol => $rolPrincipal,
                    $this->constants->contextSitio => $sitioPrincipal,
                    $this->constants->contextFirstname => $nombres,
                    $this->constants->contextLastname => $apellidos,
                    $this->constants->contextEmail => $mailPrincipal,
                    $this->constants->contextUsername => $username,
                    //$this->constants->contextAvatar => $imagenAvatar,
                    $this->constants->contextSelector => $selector,
                    $this->constants->contextFechaAcceso => $currentDate,
                    $this->constants->contextFechaExpiracion => $expirationDate,

                );
                //dd($currentDate . '---' . $timeoutSession . '---' . $expirationDate);
                session([$this->constants->servicecontextName => $serviceContext]);
                return redirect()->route('dashboard.index');
            } else {
                // Redirecciona a la pagina de login
                session([$this->constants->sessionErrorLogin => $resultDescription]);
                return redirect()->route('login');
            }
        } catch (Exception $ex) {
            Log::critical("Login Exception: " . $ex->getMessage() . '---' . $ex);
            Toastr::error(trans('msg.errProcesarInformacion') . ': ' . $ex->getMessage(), trans('labels.usuarios'), $this->constants->notificationDefaultOptions);
            return redirect()->route('usuarios.create')->withInput();
        }
    }

    public function logout()
    {
        $authUtil = new AuthUtil();
        $authUtil->removeSession();
        return redirect()->route('login');
    }

    public function getToken(Request $request)
    {
        // validacion de los parametros de entrada
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        // Continua la validacion del Request
        // Obtenemos las credenciales del usuario a ingresar
        $credentials = request(['username', 'password']);

        // Obtiene los datos del usuario (FALTA validar el password)
        $userLogin = User::getUserByUsername($request->username);

        if (isset($userLogin)) {
            $userId = $userLogin->id;
            if (password_verify($request->password, $userLogin->password)) {
                if ($userLogin->enabled) {
                    if (isset($userLogin->rol_principal_id)) {
                        if (isset($userLogin->sitio_principal_id)) {
                            $personId = $userLogin->persona_id;
                            $rolPrincipalId = $userLogin->rol_principal_id;
                            $sitioPrincipalId = $userLogin->sitio_principal_id;
                            $nombres = $userLogin->persona_nombres;
                            $apellidos = $userLogin->persona_apellidos;
                            $mailPrincipal = $userLogin->mail_principal;
                            $rolPrincipal = $userLogin->rol_nombre;
                            $sitioPrincipal = $userLogin->sitio_nombre;
                            $sitioSelector = $userLogin->sitio_selector;
                            $imagenAvatar = $userLogin->imagen_avatar;
                            $selector = $userLogin->selector;
                            // Usuario validado correctamente
                            // puede acceder al sitio
                            $resultCode = 0;
                            $resultDescription = trans('msg.msgUsuarioLoginOk');
                        } else {
                            $resultCode = 7;
                            $resultDescription = trans('msg.errUsuarioSinSitio');
                        }
                    } else {
                        $resultCode = 6;
                        $resultDescription = trans('msg.errUsuarioSinRol');
                    }
                } else {
                    $resultCode = 3;
                    $resultDescription = trans('msg.errUsuarioInactivo');
                }
            } else {
                $resultCode = 2;
                $resultDescription = trans('msg.errUsuarioPasswordIncorrecto');
            }
        } else {
            // Username no existe
            $resultCode = 1;
            $resultDescription = trans('msg.errUsuarioNoExiste');
        }


        //return $resultCode . ' ' . $resultDescription;
        if ($resultCode == 0) {
            // Obtiene el parametro configurado para el tiempo EXP del token
            $minJwtExpParam = Parametro::getValueParametroByCode('JWT_API_MIN_EXP');

            $myTTL = ($minJwtExpParam != 0) ? $minJwtExpParam : Config::get('microtess.jwt_token.exp'); //minutes
            JWTAuth::factory()->setTTL($myTTL);

            //Log::channel($this->constants->channelLogApi)->info("Login: " . $request->username . '. JWT Generated.' . ' REQUEST: ' . json_encode($request->all()));

            // Genera el token
            $jwt_token = JWTAuth::fromUser($userLogin);
            /*
            $tokenParts = explode(".", $jwt_token);  
            $tokenHeader = base64_decode($tokenParts[0]);
            $tokenPayload = base64_decode($tokenParts[1]);
            $jwtHeader = json_decode($tokenHeader);
            $jwtPayload = json_decode($tokenPayload);
            */
            return $this->successResponse([
                'token' => $jwt_token,
                //'token_expired' => Carbon::createFromTimestamp($jwtPayload->exp),
                'token_type' => 'bearer'
            ], $resultDescription);

            /*
            return response()->json([
                'success' => true,
                'message' => "Login ok",
                'token' => $jwt_token,
                'token_type' => 'bearer'
            ]);
            */
        } else {
            return $this->errorResponse($resultDescription, 401, null);
            /*
            return response()->json([
                'success' => false,
                'message' => $resultDescription,
                'token' => null,
                'token_type' => null
            ]);
            */
        }
    }
}
