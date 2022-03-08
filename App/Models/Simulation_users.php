<?php 

class Simulation_users extends Model
{	
	// función constructor de la clase
	public function __construct()
	{
		// llamamos el contructor de la clase padre
		parent::__construct();
		// variable para declarar el nombre de la tabla al cual pertenece
		$this->table = "simulation_users";
		// llenamos la variable que contiene los datos que se pueden registrar en masa 
		$this->fillable = [ "simulacion_id", "user_id", "created_at" ];
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

	public function find_by_simulation( $simulacion_id )
	{
		return parent::customer( ' SELECT t1.*, t2.name FROM ' . $this->table . ' t1 INNER JOIN users t2 ON t1.user_id = t2.id WHERE t1.simulacion_id = "'. $simulacion_id .'" ORDER BY created_at DESC ' );
	}

	// función para buscar por id
	public function delete( $primary_key )
	{
		return parent::delete( $primary_key );
	}
}