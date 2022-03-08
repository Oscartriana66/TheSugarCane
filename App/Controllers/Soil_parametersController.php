<?php

// función que carga la vista principal de la pagina
class Soil_parametersController extends Controller
{
	// función constructor del controlador
	public function __construct()
	{
		// llamamos al constructor del padre
		parent::__construct();
		// validamos que exista una sesión
		$this->auth->guest();
	}

	// función para mostrar la vista
	public function index()
	{	
		// mostramos la vista
		$this->view('soil_parameters');
	}

}