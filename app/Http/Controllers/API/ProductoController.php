<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Producto;
use Validator;
use App\Http\Resources\ProductoResource;
use Illuminate\Http\JsonResponse;
   
class ProductoController extends BaseController
{
    public function index(): JsonResponse
    {
        $productos = Producto::all();
    
        return $this->sendResponse(ProductoResource::collection($productos), 'Productos listados correctamente');
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'proveedor_id' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error de validacion', $validator->errors());       
        }
   
        $producto = Producto::create($input);
   
        return $this->sendResponse(new ProductoResource($producto), 'El producto fue creado correctamente');
    } 

    public function show($id): JsonResponse
    {
        $producto = Producto::find($id);
  
        if (is_null($producto)) {
            return $this->sendError('El producto no fue encontrado');
        }
   
        return $this->sendResponse(new ProductoResource($producto), 'El producto fue encontrado exitosamente');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required',
            'proveedor_id' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error de validacion', $validator->errors());       
        }
   
        $producto = Producto::find($id);
        $producto->nombre = $input['nombre'];
        $producto->descripcion = $input['descripcion'];
        $producto->precio = $input['precio'];
        $producto->proveedor_id = $input['proveedor_id'];
        $producto->save();
   
        return $this->sendResponse(new ProductoResource($producto), 'El producto fue actualizado correctamente');
    }
   
    public function destroy($id): JsonResponse
    {
        $producto = Producto::find($id);
        $producto->delete();
   
        return $this->sendResponse([], 'El producto fue borrado correctamente');
    }
}