<?php
class JsonLibroController extends Controller{
    
    public function get(
        mixed $param1 = NULL,
        mixed $param2 =NULL
        ):JsonResponse {
        
            if(!$param1 && !$param2)
                $libros = Libro::all();
            
            if ($param1 && $param2)
                $libros =Libro::getFiltered($param1, $param2);
            
            if ($param1 && !$param2)
                $libros = [
                    Libro::findOrFail(intval($param1), "No se encontró el libro")
                ];
                
            return new JsonResponse(
                $libros,
                "Se han recuperado ".sizeof($libros)." resultados" 
                
            );
        }
        
        public function delete(int|string $id = 0):JsonResponse{
            
            $libro = Libro::findOrFail(intval($id), "No se encontró el libro");
            
            if($libro->hasMany('Ejemplar'))
                throw new ApiException('No se puede eleiminar un libro con ejemplares');
            
                
            $libro->deleteObject();
            
            return new JsonResponse(
                [$libro],
                "Borrado del libro $libro->titulo correcto",
                );
        }
        
        public function post():JsonResponse{
            
            $libros = request()->fromJson('Libro');
            
            $response = new JsonResponse([], "Guardado correcto", 201, "CREATED");
            
            foreach ($libros as $libro){
                
                $libro->saneate();
                
                if($errores = $libro->validate()){
                    $response->setMessage("Se han producido errores.");
                    $response->setStatus("WITH ERRORS");
                    $response->addData(
                        "$libro->titulo tiene errores de validación: "
                        .arrayToString($errores, false, false)
                        );
                    
                }else{
                    
                    try{
                        $libro->save();
                        $response->addData("$libro->titulo guardado correctamnete");
                    }catch (Throwable $t){
                        $response->setMessage("Se han producido errores.");
                        $response->setStatus("WITH ERRORS");
                        $response->addData(
                            $libro->titulo.' '.(DEBUG ? $t->getMessage():" duplicado?")
                            );
                    }
                }
            }
            return $response;
        }
        
        public function put():JsonResponse {            
            
            $libros = request()->fromJson('Libro');
            
            $response = new JsonResponse([], "Actualización correcta");
            
            foreach ($libros as $libro){
                
                $libro->saneate();
                
                if($errores = $libro->validate()){
                    $response->setMessage("Se han producido errores.");
                    $response->setStatus("WITH ERRORS");
                    $response->addData(
                        "$libro->titulo tiene errores de validación: "
                        .arrayToString($errores, false, false)
                        );
                    
                }else{
                    
                    try{
                        $libro->update();
                        $response->addData("$libro->titulo actualizado correctamnete");
                        
                    }catch (Throwable $t){
                        $response->setMessage("Se han producido errores.");
                        $response->setStatus("WITH ERRORS");
                        $response->addData(
                            $libro->titulo.' '.(DEBUG ? $t->getMessage():" duplicado?")
                            );
                    }
                }
            }
            return $response;
        }
    
}