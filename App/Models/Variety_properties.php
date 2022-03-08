<?php 

class Variety_properties extends Model
{	
	// función constructor de la clase
	public function __construct()
	{
		// llamamos el contructor de la clase padre
		parent::__construct();
		// variable para declarar el nombre de la tabla al cual pertenece
		$this->table = "variety_properties";
		// llenamos la variable que contiene los datos que se pueden registrar en masa 
		$this->fillable = [ "variety_id", "natural_defoliation", "overturning_stems", "flowering", "bark_crack", "presence_laslas_chulquines", "lint_content", "average_plant_height", "stem_diameter", "internode_length", "growth_rate_cm", "growth_rate_entrenudo", "grinding_stems_time_cutting", "cane_production", "bud_production_seed", "palm_production_green_leaves", "panela_production", "yield_panela", "cachaca_production", "melote_production", "green_bagasse_production", "created_at" ];
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
	public function find_by_variety_id( $variety_id )
	{
		return parent::customer( " SELECT * FROM ". $this->table ." WHERE variety_id = '".$variety_id."' ", true );
	}
	
	// función para listar los registros
	public function listing( $pagina = 1, $input_whr = 'name', $value_whr = null )
	{
		// ejecutamos la consulta
		return parent::pagination( $pagina, $value_whr, $input_whr );
	}
}