<?php 

class Simulation extends Model
{	
	// función constructor de la clase
	public function __construct()
	{
		// llamamos el contructor de la clase padre
		parent::__construct();
		// variable para declarar el nombre de la tabla al cual pertenece
		$this->table = "simulation";
		// llenamos la variable que contiene los datos que se pueden registrar en masa 
		$this->fillable = [ "user_id", "variety_id", "number_hectares_planted", "soil_quality", "total_rainfall", "average_temperature_area", "harvest", "created_at", "updated_at" ];
		// variable que contiene los campos que no queremos dejar ver
		$this->hidden = [  ];
	}

	// función para guardar un usuario
	public function all( $input = 'id', $order = 'asc' )
	{
		return parent::all( $input, $order );
	}

	// función para buscar por id
	public function store( $request )
	{
		return parent::store( $request );
	}

	// función para buscar por id
	public function update( $request )
	{
		return parent::update( $request );
	}

	// función para buscar por id
	public function find( $primary_key )
	{
		return parent::find( $primary_key );
	}

	// función para buscar por id
	public function delete( $primary_key )
	{
		return parent::delete( $primary_key );
	}

	// función para listar los registros
	public function listing( $pagina = 1, $input_whr = 'id', $value_whr = null, $user_id )
	{
		if( $input_whr == 'variety' )
			$sql = ' SELECT t1.*, t2.name as variety FROM ' . $this->table . ' t1 INNER JOIN variety t2 ON t1.variety_id = t2.id WHERE t2.name LIKE "%' . $value_whr . '%" and t1.user_id = "'. $user_id .'" ' ;
		else
			$sql = ' SELECT t1.*, t2.name as variety FROM ' . $this->table . ' t1 INNER JOIN variety t2 ON t1.variety_id = t2.id WHERE t1.' . $input_whr . ' LIKE "%' . $value_whr . '%" and t1.user_id = "'. $user_id .'" ' ;
		// ejecutamos la consulta
		return parent::pagination( $pagina, $value_whr, $input_whr, LIMIT_PER_PAGE, $sql, 'created_at', 'desc' );
	}

	public function listing_per_user( $user_id )
	{
		return parent::customer( ' SELECT * FROM ' . $this->table . ' WHERE user_id = "'. $user_id .'" ORDER BY created_at DESC ' );
	}
}