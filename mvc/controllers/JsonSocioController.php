<?php
class JsonSocioController extends Controller{
    
    public function get(
        mixed $param1 = NULL,
        mixed $param2 = NULL
        ):JsonResponse {
            
            if(!$param1 && !$param2)
                $socios = Socio::all();
                
                if ($param1 && $param2)
                    $socios = Socio::getFiltered($param1, $param2);
                    
                    if ($param1 && !$param2)
                        $socios = [
                            Socio::findOrFail(intval($param1), "No se encontró el socio")
                        ];
                        
                        return new JsonResponse(
                            $socios,
                            "Se han recuperado ".sizeof($socios)." resultados"
                            
                            );
    }
    
    public function delete(int|string $id = 0):JsonResponse{
        
        $socio = Socio::findOrFail(intval($id), "No se encontró el socio");
        
        if($socio->hasMany('Prestamo'))
            throw new ApiException('No se puede eleiminar un libro con ejemplares');
            
            
            $socio->deleteObject();
            
            return new JsonResponse(
                [$socio],
                "Borrado del socio $socio->nombre $socio->apellidos correcto",
                );
    }
    
    public function post():JsonResponse{
        
        $socios = request()->fromJson('Socio');
        
        $response = new JsonResponse([], "Guardado correcto", 201, "CREATED");
        
        foreach ($socios as $socio){
            
            $socio->saneate();
            
            if($errores = $socio->validate()){
                $response->setMessage("Se han producido errores.");
                $response->setStatus("WITH ERRORS");
                $response->addData(
                    "$socio->nombre tiene errores de validación: "
                    .arrayToString($errores, false, false)
                    );
                
            }else{
                
                try{
                    $socio->save();
                    $response->addData("$socio->nombre $socio->apellidos guardado correctamnete");
                }catch (Throwable $t){
                    $response->setMessage("Se han producido errores.");
                    $response->setStatus("WITH ERRORS");
                    $response->addData(
                        $socio->nombre. $socio->apellidos.' '.(DEBUG ? $t->getMessage():" duplicado?")
                        );
                }
            }
        }
        return $response;
    }
    
    public function put():JsonResponse {
        
        $socios = request()->fromJson('Socio');
        
        $response = new JsonResponse([], "Actualización correcta");
        
        foreach ($socios as $socio){
            
            $socio->saneate();
            
            if($errores = $socio->validate()){
                $response->setMessage("Se han producido errores.");
                $response->setStatus("WITH ERRORS");
                $response->addData(
                    "$socio->nombre. $socio->apellidos tiene errores de validación: "
                    .arrayToString($errores, false, false)
                    );
                
            }else{
                
                try{
                    $socio->update();
                    $response->addData("$socio->nombre $socio->apellidos actualizado correctamnete");
                    
                }catch (Throwable $t){
                    $response->setMessage("Se han producido errores.");
                    $response->setStatus("WITH ERRORS");
                    $response->addData(
                        $socio->titulo.' '.(DEBUG ? $t->getMessage():" duplicado?")
                        );
                }
            }
        }
        return $response;
    }
    
}