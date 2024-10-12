<?php 
namespace Model;
class Usuario extends ActiveRecord{
    protected static $tabla='usuarios';
    protected static $columnasDB=['id','nombre','apellido','email','password','telefono','admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public $password;

    public function __construct($args=[]){
        $this->id=$args['id']??NULL;
        $this->nombre=$args['nombre']??'';
        $this->apellido=$args['apellido']??'';
        $this->email=$args['email']??'';
        $this->telefono=$args['telefono']??'';
        $this->admin=$args['admin']??0;//tinyint
        $this->confirmado=$args['confirmado']??0;//tinyint
        $this->token=$args['token']??'';
        $this->password=$args['password']??'';
    }
    //mensajes de validacion de creacion de user
    public function validarNuevo(){
        if(!$this->nombre){
            self::$alertas['error'][]='Nombre invalido';
        }
        if(!$this->apellido){
            self::$alertas['error'][]='Apellido invalido';
        }
        if(!$this->telefono){
            self::$alertas['error'][]='Telefono invalido';
        }
        if(!$this->email){
            self::$alertas['error'][]='Email invalido';
        }
        if(!$this->password){
            self::$alertas['error'][]='Password invalido';
        }
        if(strlen($this->password)< 6){//strlen retorna el ancho del string
            self::$alertas['error'][]='Password debe tener minimo 6 caracteres';
        }
        if(!ctype_upper($this->password[0])){
            self::$alertas['error'][]='Password debe comenzar con mayuscula';
        }
         
        return self::$alertas;
    }
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][]='Mail es Obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][]='Password es Obligatorio';
        }
        return self::$alertas;
    }
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][]='Email invalido';
        }
        return self::$alertas;
    }
    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][]='Password es Obligatorio';
        }
        if(strlen($this->password)< 6){//strlen retorna el ancho del string
            self::$alertas['error'][]='Password debe tener minimo 6 caracteres';
        }
        if(!empty($this->password)){//comprueba que password no este vacio 
         if(!ctype_upper($this->password[0])){
            self::$alertas['error'][]='Password debe comenzar con mayuscula';
            }
        }
        return self::$alertas;
    }
    public function existeUsuario(){
        $query= " SELECT * FROM " . self::$tabla . " WHERE email= '" . $this->email ."' LIMIT 1";
         
        $resultado=self::$db->query($query);
            if($resultado->num_rows){
                self::$alertas['error'][]='Este email ya fue registrado con otra cuenta';
            }
            return $resultado;
    }
    public function hashPassword()  {
        $this->password=password_hash($this->password,PASSWORD_BCRYPT);
    }
    public function crearToken(){
        $this->token=uniqid(); //genera un codfigo aleatorio para ser validado como token
    }
    public  function comprobarPasswordAndVerificado($password){
        $resultado=password_verify($password,$this->password);
        if(!$this->confirmado || !$resultado){
            self::$alertas['error'][]='Debe confirmar su usuario o password incorrecto';
        }else{
            return true;
        }
      
   }
}