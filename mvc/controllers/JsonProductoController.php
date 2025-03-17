<?php
class JsonProductoController extends Controller{
    
    public function get(
        mixed $param1 = NULL,
        mixed $param2 = NULL
        ):JsonResponse {
            
            if(!$param1 && !$param2)
                $productos = producto::all();
                
                if ($param1 && $param2)
                    $productos = Producto::getFiltered($param1, $param2);
                    
                    if ($param1 && !$param2)
                        $productos = [
                            Producto::findOrFail(intval($param1), "No se encontró el producto")
                        ];
                        
                        return new JsonResponse(
                            $productos,
                            "Se han recuperado ".sizeof($productos)." resultados"
                            
                            );
    }
    
    public function delete(int|string $id = 0):JsonResponse{
        
        $producto = Producto::findOrFail(intval($id), "No se encontró el producto");
         
        $producto->deleteObject();
            
            return new JsonResponse(
                [$producto],
                "Borrado del producto $producto->titulo correcto",
                );
    }
    
    public function post():JsonResponse{
        
        $productos = request()->fromJson('Producto');
        
        $response = new JsonResponse([], "Guardado correcto", 201, "CREATED");
        
        foreach ($productos as $producto){
            
            $producto->saneate();
            
            if($errores = $producto->validate()){
                $response->setMessage("Se han producido errores.");
                $response->setStatus("WITH ERRORS");
                $response->addData(
                    "$producto->titulo tiene errores de validación: "
                    .arrayToString($errores, false, false)
                    );
                
            }else{
                
                try{
                    $producto->save();
                    $response->addData("$productos->titulo guardado correctamnete");
                }catch (Throwable $t){
                    $response->setMessage("Se han producido errores.");
                    $response->setStatus("WITH ERRORS");
                    $response->addData(
                        $productos->tiutlo.' '.(DEBUG ? $t->getMessage():" duplicado?")
                        );
                }
            }
        }
        return $response;
    }
    
    public function put():JsonResponse {
        
        $productos = request()->fromJson('Producto');
        
        $response = new JsonResponse([], "Actualización correcta");
        
        foreach ($productos as $producto){
            
            $producto->saneate();
            
            if($errores = $producto->validate()){
                $response->setMessage("Se han producido errores.");
                $response->setStatus("WITH ERRORS");
                $response->addData(
                    "$producto->titulo. tiene errores de validación: "
                    .arrayToString($errores, false, false)
                    );
                
            }else{
                
                try{
                    $producto->update();
                    $response->addData("$productos->titulo actualizado correctamnete");
                    
                }catch (Throwable $t){
                    $response->setMessage("Se han producido errores.");
                    $response->setStatus("WITH ERRORS");
                    $response->addData(
                        $productos->titulo.' '.(DEBUG ? $t->getMessage():" duplicado?")
                        );
                }
            }
        }
        return $response;
    }
    
}
