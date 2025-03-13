<?php
class JsonAdminController extends Controller{
    
    
    public function delete():JsonResponse{
        
        try{
            (DB_CLASS)::get()->query("CALL retore()");
            return new JsonResponse([], "BDD restaurada", 200, "OK");
            
        }catch(SQLException $e){
            return new JsonResponse([],  "Se ha producido errores", 200, "WITH ERRORS");
        }
        
    }
}