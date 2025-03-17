<?php
class JsonUserController extends Controller{
    
    public function get(
        mixed $param1 = NULL,
        mixed $param2 =NULL
        ):JsonResponse {
            
            if(!$param1 && !$param2)
                $users = User::all();
                
                if ($param1 && $param2)
                    $users =User::getFiltered($param1, $param2);
                    
                    if ($param1 && !$param2)
                        $users = [
                            User::findOrFail(intval($param1), "No se encontró el usuario")
                        ];
                        
                        return new JsonResponse(
                            $users,
                            "Se han recuperado ".sizeof($users)." resultados"
                            
                            );
    }
    
    public function delete(int|string $id = 0):JsonResponse{
        
        $user = User::findOrFail(intval($id), "No se encontró el usuario");
        
        $user->deleteObject();
            
            return new JsonResponse(
                [$user],
                "Borrado del ususario $user->nombreyapellidos correcto",
                );
    }
    
    public function post():JsonResponse{
        
        $users = request()->fromJson('User');
        
        $response = new JsonResponse([], "Guardado correcto", 201, "CREATED");
        
        foreach ($users as $user){
            
            $user->saneate();
            
            if($errores = $user->validate()){
                $response->setMessage("Se han producido errores.");
                $response->setStatus("WITH ERRORS");
                $response->addData(
                    "$user->nombreyapellidos tiene errores de validación: "
                    .arrayToString($errores, false, false)
                    );
                
            }else{
                
                try{
                    $user->save();
                    $response->addData("$user->nombreyapellidos guardado correctamnete");
                }catch (Throwable $t){
                    $response->setMessage("Se han producido errores.");
                    $response->setStatus("WITH ERRORS");
                    $response->addData(
                        $user->nombreyapellidos.' '.(DEBUG ? $t->getMessage():" duplicado?")
                        );
                }
            }
        }
        return $response;
    }
    
    public function put():JsonResponse {
        
        $users = request()->fromJson('User');
        
        $response = new JsonResponse([], "Actualización correcta");
        
        foreach ($users as $user){
            
            $user->saneate();
            
            if($errores = $user->validate()){
                $response->setMessage("Se han producido errores.");
                $response->setStatus("WITH ERRORS");
                $response->addData(
                    "$user->nombreyapellidos tiene errores de validación: "
                    .arrayToString($errores, false, false)
                    );
                
            }else{
                
                try{
                    $user->update();
                    $response->addData("$user->nombreyapellidos actualizado correctamnete");
                    
                }catch (Throwable $t){
                    $response->setMessage("Se han producido errores.");
                    $response->setStatus("WITH ERRORS");
                    $response->addData(
                        $user->nombreyapellidos.' '.(DEBUG ? $t->getMessage():" duplicado?")
                        );
                }
            }
        }
        return $response;
    }
    
}
