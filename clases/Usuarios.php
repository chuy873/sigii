<?php 
/**
 * Clase Usuarios
 * Objeto usuario con sus datos personales.
 * El objeto es requerido por la sesion.
 * @author Oziel
 *
 */
 class Usuarios {

	private $idU; //primary key
	private $nombre;
	private $apellidos;
    private $email;
    private $telefono;
 	private $tipo; //admin, revision, captura, análisis, cliente.	
	private $username;
	private $password;
	
	//Constructor Usuarios vacio
	public function __construct()
	{	
		$this->idU = 0;
		$this->nombre = "";
		$this->apellidos = "";
		$this->email = "";
		$this->telefono = 0;
		$this->tipo="";
		$this->username="";
		$this->password="";
		
	}
		
	//Setters y getters
	public function IdU() {
        return $this->idU;
    }

    public function setIdU($idU) {
        $this->idU = $idU;
    }
       	
	public function getNombre() {
        return  $this->nombre;
    }

    public function setNombre($nombre) {
         $this->nombre = $nombre;
    }
	
	public function getApellidos() {
        return  $this->apellidos;
    }

    public function setApellidos($apellidos) {
         $this->apellidos = $apellidos;
    }
    
    
    public function getEmail() {
        return  $this->email;
    }

    public function setEmail($email) {
         $this->email = $email;
    }
    
    public function getTelefono() {
        return  $this->telefono;
    }

    public function setTelefono($telefono) {
		 $this->telefono = $telefono;
	}
    
    public function getTipo() {
		return  $this->tipo;
	}

	public function setTipo($tipo) {
		 $this->tipo = $tipo;
	}

	public function getUsername() {
		return  $this->username;
	}

	public function setUsername($username) {
		 $this->username = $username;
	}

	public function getPassword() {
		return  $this->password;
	}

	public function setPassword($password) {
		 $this->password = $password;
	}

}
?>