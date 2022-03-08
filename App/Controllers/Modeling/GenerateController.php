<?php

require_once APP.'/Models/Modeling/Generate.php';

// función que carga la vista principal de la pagina
class GenerateController extends Controller
{
	public function __construct()
	{
		// instanciamos la sesión
		$this->generateModel = new Generate();
	}

	// función para mostrar la vista
	public function index()
	{
		// mensaje de alerta
		echo "⏳ Iniciando proceso de creación de modelos...<br><br>";
		// obtenemos las tablas de la bd
		$tables = $this->get_tables();
		// mensaje de alerta
		echo "⌛ Tablas cargadas con éxito...<br><br>";
		// recorremos todas las tablas encontradas
		foreach ( $tables as $table ) 
		{
			// capturamos el nombre de la tabla
			$name_table = $table[ 'Tables_in_'.DB['NAME'] ];
			// validamos si la tabla es diferente a usuarios
			if( $name_table != "users" )
			{
				// mostramos los detalles de la tabla
				$inputs = $this->description_table( $name_table );
				// mensaje de alerta
				echo " &nbsp;&nbsp;&nbsp;&nbsp; ⌚ Iniciando proceso de creación del modelo...<br><br>";
				// generamos el archivo
				$file = fopen( APP. "/Models/" . ucfirst( $name_table ) . ".php", "w") or die("No se ha podido crear el modelo " . ucfirst( $name_table ) );
				// mensaje de alerta
				echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ✔ Archivo creado con éxito...<br><br>";
				// generamos el archivo
				$content = $this->generate_content_file( $name_table, $inputs );
				// mensaje de alerta
				echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ✔ Contenido generado con éxito...<br><br>";
				fwrite( $file, $content );
				// mensaje de alerta
				echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ✔ Archivo escrito con éxito...<br><br>";
				// cerramos el archivo
				fclose( $file );
				// mensaje de alerta
				echo " &nbsp;&nbsp;&nbsp;&nbsp; ✅  Proceso completado con éxito...<br><br>";
			}
		}
		// mensaje de alerta
		echo "✨ ".strtoupper( "<b>Se ha completado todo el proceso de crearciÓn de modelos con Éxito</b>" )." ✨ <br><br><br><br>";
		// mensaje de alerta
		echo "<a href='".URL."/'>Regresar al controlador inicial</a> <br><br><br><br>";
	}

	// función para obtener las base de datos
	private function get_tables()
	{
		// validamos si la conexión esta activa
		if( DB['STATUS'] == 'on' )
			// retornamos las tablas encontradas
			return $this->generateModel->customer(" SHOW FULL TABLES FROM " . DB['NAME'] );
		else
			// redireccionamos a un error
			$this->redirect('/Errors/Conex');
	}

	// función para mostrar la descrpción de las tablas
	private function description_table( $table )
	{
		// buscamos los datos de los campos de la tabla
		$inputs = $this->generateModel->customer(" SHOW COLUMNS FROM " . DB['NAME'] . "." . $table );
		// mensaje de alerta
		echo "🔎 Mostrando campos de la tabla <b>" . ucwords( $table ) . "</b>:";
		// variable que contiene los nombres de los campos
		$show_inputs = '[ ';
		// recorremos los campos
		foreach ( $inputs as $input ) 
		{
			// capturamos los campos
			$show_inputs .= '"'.$input["Field"].'", ';
		}
		// eliminamos el campo final
		$show_inputs = substr($show_inputs, 0, -2);
		// agregamos el campo final
		$show_inputs .= ' ]';
		// mensaje de alerta		
		echo $show_inputs."<br><br>";
		// retornamos los campos encontrados
		return $show_inputs;
	}

	// función para crear el contenido por defecto de los modelos
	private function generate_content_file( $name_table, $inputs )
	{
		return '<?php

// Modelo generado por medio de Blue Ghost
class ' . ucwords( $name_table ) . ' extends Model
{
	// función constructor del modelo
	public function __construct()
	{
		// llamamos el contructor de la clase padre
		parent::__construct();
		// variable para declarar el nombre de la tabla al cual pertenece
		$this->table = "' . $name_table . '";
		// llenamos la variable que contiene los datos que se pueden registrar en masa 
		$this->fillable = ' . $inputs .';
		// variable que contiene los campos que no queremos dejar ver
		$this->hidden = [];
	}

	// función para buscar todos los datos
	public function all( $input = "id", $order = "asc" )
	{
		return parent::all( $input, $order );
	}

	// función para guardar una tupla
	public function store( $request )
	{
		return parent::store( $request );
	}

	// función para actualizar una tupla
	public function update( $request )
	{
		return parent::update( $request );
	}

	// función para búscar una tupla
	public function find( $primary_key )
	{
		return parent::find( $primary_key );
	}

	// función para eliminar una tupla
	public function delete( $primary_key )
	{
		return parent::delete( $primary_key );
	}

	// función para listar las tuplas
	public function listing( $pagina = 1, $input_whr = "id", $value_whr = null )
	{
		// ejecutamos la consulta
		return parent::pagination( $pagina, $value_whr, $input_whr );
	}

}';
	}

}