<?php

class usuario {
	private $id;
	private $nombre;
	private $apellido;
	private $dni;
	private $user;
	private $pass;
	private $fechaRegistro;

	function __construct()
	{
		
	}

	function altaUsuario ($id, $nombre, $apellido, $dni, $user, $pass, $fechaRegistro){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->dni = $dni;
		$this->user = $user;
		$this->pass = $pass;
		$this->fechaRegistro = $fechaRegistro;
	}
	
	function modifUsuario ($id, $nombre, $apellido, $dni, $user, $pass, $fechaRegistro){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->dni = $dni;
		$this->user = $user;
		$this->pass = $pass;
		$this->fechaRegistro = $fechaRegistro;
	}
	
	function bajaUsuario ($id){
		
	}
	function mostrar ($id){
		return "id: ".$this->id."<br>".
		"nombre: ".$this->nombre."<br>".
		"apellido: ".$this->apellido."<br>".
		"dni: ".$this->dni."<br>".
		"user: ".$this->user."<br>".
		"fecha de registro: ".$this->fechaRegistro;
	}

	function __destruct()
	{
		
	}
}
?>