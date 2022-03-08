<?php

// función que carga la vista principal de la pagina
class VarietyController extends Controller
{
	// función constructor del controlador
	public function __construct()
	{
		// llamamos al constructor del padre
		parent::__construct();
		// validamos que exista una sesión
		$this->auth->guest();
		// instanciamos el modelo de usuario
		$this->varietyModel = $this->model('Variety');
	}

	// función para mostrar la vista
	public function index()
	{	
		// mostramos la vista
		$this->redirect('welcome');
	}


	public function find_by_select()
	{
		// capturamos el nombre
		$name = $_POST['value'];
		// buscamos los datos
		$rows = $this->varietyModel->find_by_select( $name );
		// validamos si hay un error
		if( !$rows )
		{
			// Agregamos el mensaje a la variable para ser mostrada
			array_push( $this->errors, $rows );
			// Mostramos el mensaje de error al usuario
			echo $this->errors();
			// evitamos que siga ejecutando
			exit();
		}
		// variable que mostrara los resultados
		$result = '';
		// recorremos los resultados
		foreach ( $rows as $item ) 
		{
				// concatenamos los resultados
			$result .= '
				<a class="option_loaded" data-value="'.$item['name'].'" data-value-2="'.$item['id'].'">
					'.$item['name'].'
				</a>
			';
		}
		// mostramos los datos
		echo $result;
	}

}