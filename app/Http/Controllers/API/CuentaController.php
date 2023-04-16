<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Laravel\Sanctum\PersonalAccessToken;
   
class CuentaController extends BaseController
{
    public function cambiarUsuario(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error de validacion', $validator->errors());       
        }
   
        $input = $request->all();

        $user = User::find($input['id']);
        $user->username = $input['nombre'];
        $user->save();
   
        return $this->sendResponse([], 'Cambio de usuario registrado correctamente');
    }

    public function cambiarClave(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'clave' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error de validacion', $validator->errors());       
        }
   
        $input = $request->all();

        $user = User::find($input['id']);
        $user->password = bcrypt($input['clave']);
        $user->save();
   
        return $this->sendResponse([], 'Cambio de clave registrada correctamente');
    }

    public function salir(Request $request): JsonResponse
    {
        $token = PersonalAccessToken::findToken($request->token);
        if($token) {
            $token->delete();
            return $this->sendResponse([], 'Token borrado correctamente');
        } else {
            return $this->sendError('No se encontro token', ['error'=>'No se encontro token']);
        }
    }
}