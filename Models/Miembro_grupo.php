<?php
	namespace Models;


	abstract class Miembro_grupo{

		protected $id_grupo;
		protected $fecha_agregado;
		protected $acceso_grupo;
		protected $status_miembro;

		public abstract function validar_miembro($arg);
		public abstract function unirse();
		public abstract function abandonar();
		public abstract function aceptar_miembro();
		public abstract function banear_miembro();
		public abstract function ver_baneos();
		public abstract function borrar_miembro();
	}

 ?>