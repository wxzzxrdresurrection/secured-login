<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use App\Jobs\Mailer;
use App\Jobs\TFAJob;
use App\Models\User;
use App\Models\Constants;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{

    /**
    * Muestra la vista de registro
    */
    public function registerView()
    {
        try{
            $env = env('RECAPTCHA_SITE_KEY');
            return view('welcome', ['siteKey' => "6LdUl14pAAAAABdQ-AFh6c6iYCYNvURFy1UYh-3p"]);
        }
        catch(Exception $e){
            Log::error("Error: $e");
            return redirect('/')->withErrors('error', Constants::getExceptionMessage());
        }
    }

    /**
    * Registra a un nuevo usuario
    */
    public function register(Request $request)
    {
        try{
            #Validar informacion del request
            $validator = Validator::make($request->all(), [
                    'g-recaptcha-response' => 'required',
                    'name' => 'required|max:100|regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/',
                    'email' => 'required|email',
                    'password' => 'required|min:8|confirmed',
                    'phone' => 'required|numeric',
                ],
                [
                    'g-recaptcha-response.required' => 'La verificación de captcha es requerida',
                    'name.required' => 'El nombre es obligatorio',
                    'name.regex' => 'El nombre no tiene un formato válido',
                    'name.max' => 'El nombre debe tener un máximo de 100 caracteres',
                    'email.required' => 'El correo es obligatorio',
                    'email.email' => ' El correo debe ser un correo electrónico válido',
                    'password.required' => 'La contraseña es obligatoria',
                    'password.min' => ' La contraseña debe tener al menos 8 caracteres',
                    'password.confirmed' => 'Las contraseñas no coinciden',
                    'phone.required' => 'El telefono es obligatorio',
                    'phone.numeric' => 'El telefono debe ser un número',
                ]
            );

            #Consultar el servicio de google para validar el captcha
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => '6LdUl14pAAAAAMvTv8F3KGKItWzd8kzKna5zTN0u',
                'response' => $request->input('g-recaptcha-response'),
            ]);

            $isCaptchaValid = $response->json()['success'];

            if ($validator->fails() || !$isCaptchaValid) {
                if (!$isCaptchaValid) {
                    $validator->errors()->add('captcha', 'Captcha inválido. Intente de nuevo');
                }
                return back()
                            ->withErrors($validator->errors());
                            //->withInput();
            }

            #Consultar los usuarios
            $users = User::all();

            #Crear usuario como administrador si no hay usuarios registrados
            if($users->isEmpty()){
                $role = Constants::getAdminRole();
            }
            else{
                $role = Constants::getUserRole();
            }

            #Crear usuario
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'phone' => $request->input('phone'),
                'role_id' => $role
            ]);

            Log::info('Usuario creado', ['user' => $user]);

            #Crear ruta firmada para activar el usuario
            $url = URL::temporarySignedRoute(
                'activate', now()->addMinutes(30), ['id' => $user->id]
            );

            #Enviar correo electronico
            Mailer::dispatch($user, $url)
            ->delay(now()->addSeconds(10))
            ->onQueue('mails')
            ->onConnection('database');

            return redirect('/verify/mail');
        }
        catch(PDOException $e){
            Log::error("Error: $e");
            return redirect('/')->withErrors('error', Constants::getPDOMessage());
        }
        catch(QueryException $e){
            Log::error("Error: $e");
            return redirect('/')->withErrors('error', Constants::getQueryMessage());
        }
        catch(ValidationException $e){
            Log::error("Error: $e");
            return redirect('/')->withErrors('error', Constants::getValidationMessage());
        }
        catch(Exception $e){
            Log::error("Error: $e");
            return redirect('/')->withErrors('error', Constants::getExceptionMessage());
        }
    }

    /**
    * Muestra la vista de verificacion de correo electronico
    */
    public function verifyMailView(){
        return view('checkMail');
    }

    /**
    * Activa la cuenta de un usuario
    */
    public function activate(Request $request, $id){

        try{
            #Validar la firma de la ruta
            if (!$request->hasValidSignature()) {
                return view('invalidRoute');
            }

            #Consultar el usuario para verificar si no ha sido activado previamente
            $user = User::find($id);
            if($user->active){
                return redirect('/login')->withErrors(['error' => 'Esta cuenta ya ha sido activada']);
            }

            #Activar el usuario
            $user->active = true;
            $user->email_verified_at = now();
            $user->save();

            #Redireccionar a la pagina principal
            return redirect('/login');
        }
        catch(PDOException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors('error', Constants::getPDOMessage());
       }
       catch(QueryException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors('error', Constants::getQueryMessage());
       }
       catch(ValidationException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors('error', Constants::getValidationMessage());
       }
       catch(Exception $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors('error', Constants::getExceptionMessage());
       }

    }

    /**
    * Muestra la vista de inicio de sesion
    */
    public function loginView(){
        return view('login');
    }

    /**
    * Inicia sesion de un usuario
    */
    public function login(Request $request){

        try{
            #Validar informacion del request
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ],
            [
                'email.required' => 'El correo es obligatorio',
                'email.email' => ' El correo debe ser un correo electrónico válido',
                'password.required' => 'El contraseña es obligatorio',
                'password.min' => ' La contraseña debe tener al menos 8 caracteres',
            ]);

            #Regresar si hay errores
            if ($validator->fails()) {
                return redirect('/login')
                            ->withErrors($validator->errors())
                            ->withInput();
            }


            #Consultar el usuario
            $user = User::where('email', $request->input('email'))->first();
            #Regresar si el usuario no existe o la contraseña es incorrecta
            if(!$user || !Hash::check($request->input('password'), $user->password)){
                return redirect('/login')->withErrors(['login' => 'Usuario o contraseña incorrectos']);
            }

            #Regresar si el admin no se encuentra en la VPN y el usuario entra por VPN
            if(($user->role_id == Constants::getAdminRole() && $request->ip() != '10.8.20.29') || ($user->role_id == Constants::getUserRole() && $request->ip() == '10.8.20.29')){
                return redirect('/login')->withErrors(['login' => 'Acceso restringido']);
            }

            #Regresar si el usuario no esta activo
            if(!$user->active){

                #Crear ruta firmada para activar el usuario
                $url = URL::temporarySignedRoute(
                    'activate', now()->addMinutes(30), ['id' => $user->id]
                );

                #Enviar correo electronico
                Mailer::dispatch($user, $url)
                ->delay(now()->addSeconds(10))
                ->onQueue('mails')
                ->onConnection('database');

                return redirect('/verify/mail');
            }

            #Crear ruta firmada para activar el usuario
            $url = URL::temporarySignedRoute(
                'authentication', now()->addMinutes(30), ['id' => $user->id]
            );

            $code = rand(100000, 999999);

            #Enviar correo electronico
            TFAJob::dispatch($user, $code)
            ->delay(now()->addSeconds(10))
            ->onQueue('mails')
            ->onConnection('database');

            if($user->role_id == Constants::getAdminRole())
            {
                $user->extra_code = Hash::make($code);
            }
            else{
                $user->code = Hash::make($code);
            }

            $user->save();

            return redirect('/verify/code')->with('url',$url);

        }
        catch(PDOException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getPDOMessage()]);
        }
        catch(QueryException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getQueryMessage()]);
        }
        catch(ValidationException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getValidationMessage()]);
        }
        catch(Exception $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getExceptionMessage()]);
        }

    }

    /**
    * Muestra la vista de verificacion de codigo
    */
    public function verifyCodeView(){
        return view('verifyCode');
    }

    /**
    * Verifica el codigo de autenticacion
    */
    public function authentication(Request $request){

        try{
            #Validar la firma de la ruta
            if (!$request->hasValidSignature()) {
                return view('invalidRoute');
            }

            #Validar informacion del request
            $validator = Validator::make($request->all(), [
                'code' => 'required|numeric|digits:6',
            ]);

            #Regresar si hay errores
            if ($validator->fails()) {
                return redirect('/login')
                            ->withErrors($validator->errors())
                            ->withInput();
            }

            #Consultar el usuario
            $user = User::find($request->id);

            #Regresar si el usuario no existe
            if(!$user){
                return redirect('/login')->withErrors(['error' => 'Usuario no encontrado']);
            }

            if($user->code == null){
                return redirect('/verify/code')->withErrors(['error' => 'Codigo incorrecto']);
            }

            #Regresar si el codigo es incorrecto
            if (!Hash::check($request->input('code'), $user->code)){
                return redirect('/verify/code')->withErrors(['error' => 'Codigo incorrecto']);
            }

            #Iniciar sesion
            Auth::loginUsingId($user->id);

            Log::info("El usuario $user->email ha iniciado sesion");
            return redirect('/home')->with('user', $user);
        }
        catch(PDOException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getPDOMessage()]);
        }
        catch(QueryException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getQueryMessage()]);
        }
        catch(ValidationException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getValidationMessage()]);
        }
        catch(Exception $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getExceptionMessage()]);
        }

    }

    /**
    * Muestra la vista de inicio
    */
    public function homeView(){
        try{
            #Redireccionar a la pagina de inicio de sesion si no hay un usuario autenticado
            if(!Auth::check()){
                return redirect('/login');
            }

            #Obtener el rol del usuario para mostrar la vista
            $user = Auth::user();
            return view('home', ['user' => $user]);
        }
        catch(PDOException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getPDOMessage()]);
        }
        catch(QueryException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getQueryMessage()]);
        }
        catch(ValidationException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getValidationMessage()]);
        }
        catch(Exception $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getExceptionMessage()]);
        }
    }

    /**
     * Cierra la sesion de un usuario
     */
    public function logout(Request $request){
        try{
            #Cerrar sesion
            Auth::logout();
            #Invalidar y regenerar el token de la sesion
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login');
        }
        catch(PDOException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getPDOMessage()]);
        }
        catch(QueryException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getQueryMessage()]);
        }
        catch(ValidationException $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getValidationMessage()]);
        }
        catch(Exception $e){
            Log::error("Error: $e");
            return redirect('/login')->withErrors(['error' => Constants::getExceptionMessage()]);
        }
    }

}
