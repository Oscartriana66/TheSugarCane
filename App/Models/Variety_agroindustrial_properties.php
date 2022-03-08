<?php 

class Variety_agroindustrial_properties extends Model
{	
	// función constructor de la clase
	public function __construct()
	{
		// llamamos el contructor de la clase padre
		parent::__construct();
		// variable para declarar el nombre de la tabla al cual pertenece
		$this->table = "variety_agroindustrial_properties";
		// llenamos la variable que contiene los datos que se pueden registrar en masa 
		$this->fillable = [ "variety_id", "type", "brix", "ph", "sugars", "saccharose", "purity", "phosphor", "humidity", "created_at" ];
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

	// función para buscar una variedad por nombre
	public function find_by_variety_id_and_type( $variety_id, $type )
	{
		return parent::customer( " SELECT * FROM ". $this->table ." WHERE variety_id = '".$variety_id."' and type = '".$type."' ", true );
	}
	
	// función para listar los registros
	public function listing( $pagina = 1, $input_whr = 'name', $value_whr = null )
	{
		// ejecutamos la consulta
		return parent::pagination( $pagina, $value_whr, $input_whr );
	}
}