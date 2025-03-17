<?php
class Producto extends Model{
    
    /*public function validate(bool $checkId = false):array{
        $errores = [];
        
        //dni y nie validación
        if (empty($this->dni) || !preg_match("/^(\d{8}[A-Z]|[XYZ]\d{7}[A-Z])$/", $this->dni))
            $errores['DNI'] = "Error en el formato del DNI";
            
            //título de 1 al 25 caracteres
            if (empty($this->nombre) || strlen($this->nombre) < 1 || strlen($this->nombre) > 25)
                $errores['nombre'] = "Error en la longitud del nombre";
                
                //apellidos
                if (empty($this->apellidos) || strlen($this->apellidos) < 1 || strlen($this->apellidos) > 60)
                    $errores['apellidos'] = "Error en el número de apellidos";
                    
                    //edad recomendada de 0 a 120
                    if (empty($this->email) || !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $this->email))
                        $errores['email'] = "Error en la email";
                        
                        //título de 1 al 25 caracteres
                        if (empty($this->direccion) || strlen($this->direccion) < 1 || strlen($this->direccion) > 60)
                            $errores['direccion'] = "Error en la dirección";
                            
                            //codigo postal solo 5 digitos
                            if (empty($this->cp) || !preg_match("/^([0-4][0-9]{4}|5[0-2][0-9]{3})$/", $this->cp))
                                $errores['cp'] = "Error en el codigo postal";
                                
                                //Población
                                if (empty($this->poblacion) || !preg_match("/^[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?:[\s-][A-ZÁÉÍÓÚÑa-záéíóúñ]+)*$/", $this->poblacion))
                                    $errores['poblacion'] = "Error en la población";
                                    
                                    //Provincia
                                    if (empty($this->provincia) || !preg_match("/^[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?:[\s-][A-ZÁÉÍÓÚÑa-záéíóúñ]+)*$/", $this->provincia))
                                        $errores['provincia'] = "Error en la provincia";
                                        
                                        //Teléfono
                                        if (empty($this->telefono) || !preg_match("/^(\+34\s?|0034\s?|34\s?)?[6789]\d{8}$/", $this->telefono))
                                            $errores['telefono'] = "Error en el número de teléfono";
                                            
                                            return $errores;     //retorna la lista de errores
    }*/
}

