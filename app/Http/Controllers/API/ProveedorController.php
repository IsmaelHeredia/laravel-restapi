<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Proveedor;
use Validator;
use App\Http\Resources\ProveedorResource;
use Illuminate\Http\JsonResponse;
   
class ProveedorController extends BaseController
{
    public function index(): JsonResponse
    {
        $proveedores = Proveedor::all();
    
        return $this->sendResponse(ProveedorResource::collection($proveedores), 'Proveedores listados correctamente');
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error de validacion', $validator->errors());       
        }
   
        $proveedor = Proveedor::create($input);
   
        return $this->sendResponse(new ProveedorResource($proveedor), 'El proveedor fue creado correctamente');
    } 

    public function show($id): JsonResponse
    {
        $proveedor = Proveedor::find($id);
  
        if (is_null($proveedor)) {
            return $this->sendError('El proveedor no fue encontrado');
        }
   
        return $this->sendResponse(new ProveedorResource($proveedor), 'El proveedor fue encontrado exitosamente');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'nombre' => 'required',
            'direccion' => 'required',
            'telefono' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error de validacion', $validator->errors());       
        }
   
        $proveedor = Proveedor::find($id);
        $proveedor->nombre = $input['nombre'];
        $proveedor->direccion = $input['direccion'];
        $proveedor->telefono = $input['telefono'];
        $proveedor->save();
   
        return $this->sendResponse(new ProveedorResource($proveedor), 'El proveedor fue actualizado correctamente');
    }

    public function destroy($id): JsonResponse
    {
        $proveedor = Proveedor::find($id);
        $proveedor->delete();
   
        return $this->sendResponse([], 'El proveedor fue borrado correctamente');
    }
}