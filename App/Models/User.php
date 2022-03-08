<?php 

class User extends Model
{	
	// función constructor de la clase
	public function __construct()
	{
		// llamamos el contructor de la clase padre
		parent::__construct();
		// variable para declarar el nombre de la tabla al cual pertenece
		$this->table = "users";
		// llenamos la variable que contiene los datos que se pueden registrar en masa 
		$this->fillable = [ "name", "username", "slug", "password", "role", "company", "telephone", "cc", "_token", "created_at", "updated_at" ];
		// variable que contiene los campos que no queremos dejar ver
		$this->hidden = [ "password", "_token" ];
	}

	// función para obtener un dato de la lista
	public function __get( $attribute )
	{
		// validamos si el atributo a búscar es la password
		if( $attribute == "password")
			// retornamos vacio
			return "";
		// capturamos la primary key sesionada
		@$primary_key = $_SESSION[ $this->primary_key ];
		// validamos si existe una sesión activa
		if( isset( $primary_key ) && !empty( $primary_key ) && !is_null( $primary_key ) )
		{
			// buscamos los datos del usuario
			$response = parent::customer( " SELECT * FROM " . $this->table . " WHERE " . $this->primary_key . " = '" . $primary_key . "' " );
			// capturamos los datos
			$response = parent::__fetch( $response );
			// retornamos el atributo que buscamos
			return $response[ $attribute ];
		}
		// retornamos vacio
		return "";
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

	// función para buscar un usuario por el slug
	public function find_by_slug( $slug )
	{
		return parent::customer( " SELECT * FROM ". $this->table ." WHERE slug = '".$slug."' ", true );
	}

	// función para listar los registros
	public function listing( $pagina = 1, $input_whr = 'name', $value_whr = null, $role )
	{
		if(  $role == 3 or $role == 2 )
		{
			$sql = ' SELECT * FROM ' . $this->table . ' WHERE ' . $input_whr . ' LIKE "%' . $value_whr . '%" and role = 3 ' ;
		}
		else
		{
			$sql = 'NULL';
		}
		// ejecutamos la consulta
		return parent::pagination( $pagina, $value_whr, $input_whr, LIMIT_PER_PAGE, $sql );
	}
}