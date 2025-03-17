<?php
class Producto extends Model{
    
    public function validate(bool $checkId = false):array{
        $errores = [];
        
        //título de 1 al 25 caracteres
        if (empty($this->titulo) || strlen($this->titulo) < 1 || strlen($this->titulo) > 60)
            $errores['titulo'] = "Error en la título";
            
        //Descripción
        if (empty($this->descripcion) || strlen($this->descripcion) < 1 || strlen($this->descripcion) > 1000)
            $errores['descripcion'] = "Error en la descripción";
                
        //Estado
        if (empty($this->estado) || strlen($this->estado) < 1 || strlen($this->estado) > 1000)
            $errores['estado'] = "Error en la estado";
                
            return $errores;     //retorna la lista de errores
    }
}

