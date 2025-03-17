<?php

/** Clase User
 *
 * Proveedor de usuarios por defecto para las aplicaciones de FastLight.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 * Última revisión: 05/03/2025
 */

class User extends Model implements Authenticable{

    use Authorizable; // usa el trait authorizable
    
    public function getProductos():array{
        $consulta = "SELECT * FROM productos WHERE iduser=$this->id";
        
        //retorna una lista de Ejemplar
        return DBMysqli::selectAll($consulta, 'Producto');
    }
    
    public function validate(bool $checkId = false):array{
        $errores = [];
        
        //título de 1 al 120 caracteres
        //if (empty($this->nombreyapellidos) || strlen($this->nombreyapellidos) < 1 || strlen($this->nombreyapellidos) > 120)
               // $errores['nombreyapellidos'] = "Error en la longitud del nombre";
                
        //edad recomendada de 0 a 120
        if (empty($this->email) || !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $this->email))
                $errores['email'] = "Error en la email";
                        
        //título de 1 al 25 caracteres
        if (empty($this->direccion) || strlen($this->direccion) < 1 || strlen($this->direccion) > 60)
                $errores['direccion'] = "Error en la dirección";
                            
        //Población
        if (empty($this->poblacion) || !preg_match("/^[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?:[\s-][A-ZÁÉÍÓÚÑa-záéíóúñ]+)*$/", $this->poblacion))
                $errores['poblacion'] = "Error en la población";
                                    
        //Provincia
        if (empty($this->provincia) || !preg_match("/^[A-ZÁÉÍÓÚÑa-záéíóúñ]+(?:[\s-][A-ZÁÉÍÓÚÑa-záéíóúñ]+)*$/", $this->provincia))
                $errores['provincia'] = "Error en la provincia";
                                        
        //Teléfono
        //if (empty($this->phone) || !preg_match("/^(\+34\s?|0034\s?|34\s?)?[6789]\d{8}$/", $this->phone))
                //$errores['phone'] = "Error en el número de teléfono";
                                            
        return $errores;     //retorna la lista de errores
    }
       
    
    /** @var array $jsonFields lista de campos JSON que deben convertirse en array PHP. */
    protected static $jsonFields = ['roles'];
    
    
    /** @var array $fillable lista de campos permitidos para asignaciones masivas usando el método create() */
    protected static $fillable = ['displayname', 'email', 'phone', 'password', 'picture'];

    
    /**
     * Retorna un usuario a partir de un teléfono y un email. Lo usaremos
     * en la opción "olvidé mi password".
     * 
     * @param string $phone número de teléfono.
     * @param string $email email.
     * 
     * @return User|NULL el usuario recuperado o null si no existe la combinación de email y teléfono.
     */
    public static function getByPhoneAndMail(
        string $phone,
        string $email
    ):?User{
        
        $consulta = "SELECT *  
                     FROM users  
                     WHERE phone = '$phone' 
                        AND email = '$email' ";
        
        if($usuario = (DB_CLASS)::select($consulta, self::class))
            $usuario->parseJsonFields();
        
        
        return $usuario;
    }
    
            
    // MÉTODOS DE AUTHENTICABLE
    
    /**
     * Método encargado de comprobar que el login es correcto y recuperar el usuario.
     * Permitiremos la identificación por email o teléfono.
     * 
     * @param string $emailOrPhone email o teléfono.
     * @param string $password clave del usuario.
     * 
     * @return User|NULL si la identificación es correcta retorna el usuario, en caso contrario NULL.
     */
    public static function authenticate(
        string $emailOrPhone = '',      // email o teléfono
        string $password = ''           // debe llegar encriptado con MD5
            
    ):?User{
        
        // preparación de la consulta
        $consulta="SELECT *  FROM users
                   WHERE (email='$emailOrPhone' OR phone='$emailOrPhone') 
                   AND password='$password'";
        
        $usuario = (DB_CLASS)::select($consulta, self::class);
        
        if($usuario)
            $usuario->parseJsonFields();
        
        return $usuario;
    }   
}
    
    
