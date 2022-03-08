<?php 

class Model extends Conex
{
	// variable que contiene el nombre de la tabla
	protected $table;
	// variable que contiene los datos que se pueden guardar
	protected $fillable = [];
	// variable que contiene los campos que no queremos dejar ver
	protected $hidden = [];
	// variable que contiene la clave primaria de la tabla
	protected $primary_key = 'id';
	// variable que contendra los campos y valores del sql
	private $values;

	// función constructora de la clase
	public function __construct()
	{
		// llamamos el contructor de la clase padre
		parent::__construct();
	}

	// función para ejecutar una sentencia personalizada
	// $query: sentencia SQL a ejecutar
	// $fetch: nos indica si se debe realizar un fetch al resultado de la sentencia ejecutada
	protected function customer( $query, $fetch = NULL )
	{
		// ejecutamos la consulta
		$result = parent::__query( $query );
		// validamos si tenemos un error en la ejecución de la consulta
		if( !$result['status'] )
			// retornamos el mensaje de error
			return $result['message'];
		else
			// validamos si fetch es nula para retornar los datos sin tratar
			if( is_null( $fetch ) )
				// retornamos los datos encontrados
				return $result['data'];
			else
				// retornamos los datos tratados con fetch_assoc()
				return $this->hide_inputs_hidden( parent::__fetch( $result['data'] ) );
	}

	// funcion para obtener todos los registros
	// $input: campo por donde se desea organizar
	// $order: tipo de orden por el cual se desea visualizar
	protected function all( $input = 'id', $order = 'asc' )
	{
		// ejecutamos la consulta
		$result = parent::__query( ' SELECT * FROM ' . $this->table . ' ORDER BY ' . $input . ' ' . $order );
		// validamos si tenemos un error en la ejecución de la consulta
		if( !$result['status'] )
			// retornamos el mensaje de error
			return $result['message'];
		else
			// retornamos los datos encontrados
			return $result['data'];
	}

	// funcion para obtener buscar un registro por ID
	protected function find( $primary_key )
	{
		// funcion para arreglar los campos que podemos dejar ver
		$this->selectInputs();
		// ejecutamos y retornamos los valores de la consulta
		return $this->customer(' SELECT ' . $this->values . ' FROM ' . $this->table . ' WHERE ' . $this->primary_key . ' = ' . $primary_key, true );
	}


	// funcion para crear un registro
	// $request se recibe como array con los valores en orden del fillable
	protected function store( $request )
	{
		// arreglamos el request para asignarlo en la variable values
		$this->fillableStore( $request );
		// ejecutamos el query
		return $this->validate_query( parent::__query( ' INSERT INTO ' . $this->table . $this->values ) );

	}

	// funcion para actualizar un registro
	// $request se recibe como array con los valores en orden del fillable,
	// el id tiene que ser por obligacion el primer elemento de la lista
	protected function update( $request )
	{
		// obtenemos el id del inicio del array
		$primary_key = $request[ $this->primary_key ];
		// eliminamos el id de la lista
		array_shift( $request );
		// arreglamos el request para asignarlo en la variable values
		$this->fillableUpdate( $request );
		// ejecutamos el query
		return $this->validate_query( parent::__query( ' UPDATE ' . $this->table .' SET ' . $this->values .' WHERE ' . $this->primary_key . ' = ' . $primary_key ) );
	}

	// funcion para obtener buscar un registro por ID
	protected function delete( $primary_key )
	{
		// ejecutamos el query
		return $this->validate_query( parent::__query( ' DELETE FROM ' . $this->table . ' WHERE ' . $this->primary_key . ' = ' . $primary_key ) );
	}

	// funcion para obtener todos los registros y paginar
	// $url: variable que contiene la URL de la pagina en donde se muestra el listado
	// $pagina: variable para crear el paginador
	// $value_whr: valor por el cual se realiza la busqueda
	// $input_whr: campo por donde se desea buscar
	// $limit_per_page: variable que nos indica de acuantos datos se desean listar por página
	// $sql: variable que contiene la consulta que desea personalizar, si pone el valor null la toma por defecto
	// $input_ord: campo por donde se desea organizar
	// $order: tipo de orden por el cual se desea visualizar
	protected function pagination( $pagina, $value_whr = null, $input_whr = 'id', $limit_per_page = LIMIT_PER_PAGE, $sql = 'NULL', $input_ord = 'id', $order = 'asc' )
	{
		// funcion para arreglar los campos que podemos dejar ver
		$this->selectInputs();
		// obtenemos los datos para realizar la seleccion de datos por pagina
		// $paginacion['inicio']: obtenemos la posicion de la variable de inicio
		// $paginacion['limit']: obtenemos la cantidad limite de datos a mostrar en el listado
		$paginacion = $this->limit( $pagina, $limit_per_page );
		// validamos que el parametro $sql no sea vació
		if( $sql == 'NULL' )
		{
			// asignamos el valor de la consula por defecto
			$sql = ' SELECT ' . $this->values . ' FROM ' . $this->table . ' WHERE ' . $input_whr . ' LIKE "%' . $value_whr . '%" ORDER BY ' . $input_ord . ' ' . $order . ' LIMIT ' . $paginacion['inicio'] . ', ' . $paginacion['limit'];
			// asignamos el valor de la consulta para el listado
			$all = ' SELECT ' . $this->values . ' FROM ' . $this->table . ' WHERE ' . $input_whr . ' LIKE "%' . $value_whr . '%"';
		}
		else
		{
			// asignamos el valor de la consulta para el listado
			$all =  $sql;
			// asignamos el valor de la consulta que desea crear el usuario
			$sql = $sql.' ORDER BY ' . $input_ord . ' ' . $order . ' LIMIT ' . $paginacion['inicio'] . ', ' . $paginacion['limit'];
		}
		// ejecutamos y retornamos los valores de la consulta limitada y ordenada
		$list = parent::__query( $sql );
		// validamos si existe un error en la ejecución
		if( !$list['status'] )
			// capturamos el mensaje de error
			$list = $list['message'];
		else
			// capturamos los datos
			$list = $list['data'];
		// ejecutamos y retornamos los valores de la consulta sin limites
		$all = parent::__query( $all );
		// variable que contiene la cantidad lista
		$cant = 0;
		// variable que contiene el renderizado de la páginación
		$render = '';
		// validamos si existe un error en la ejecución
		if( !$all['status'] )
			// capturamos el mensaje de error
			$render = $all['message'];
		else
		{
			// obtenemos la cantidad de datos encontrados
			$cant = $all['data']->num_rows;
			// obtenemos el renderizado de los links de la paginacion
			$render = $this->render( $pagina, $value_whr, $cant, $limit_per_page );
		}
		// retornamos la respuesta
		return [
			'list' => $list,
			'cant' => $cant,
			'render' => $render
		];
	}

	// funcion para obtener la seleccion de datos por pagina
	// $pagina: variable para crear el paginador
	// $limit_per_page: variable que nos indica de acuantos datos se desean listar por página
	protected function limit( $pagina, $limit_per_page )
	{
		//examino la página a mostrar y el inicio del registro a mostrar
		if ( $pagina === 1 )
			// declaramos que inicie desde el dato 0
			$inicio = 0;
		else
			// calculamos el dato de inicio
		   $inicio = ( $pagina - 1 ) * $limit_per_page;
		// retonramos los datos calculados
		return [ 'inicio' => $inicio, 'limit' => $limit_per_page ];
	}

	// funcion para crear los links de la paginacion
	// $url: variable que contiene la URL de la pagina en donde se muestra el listado
	// $pagina: variable para crear el paginador
	// $value_whr: valor por el cual se realiza la busqueda
	// $cant: numero total de registros
	// $limit_per_page: variable que nos indica de acuantos datos se desean listar por página
	protected function render( $pagina, $value_whr, $cant, $limit_per_page )
	{
		// variable que renderiza el listado
		$links = '<div class="content_pagination">';
		//calculo el total de páginas
		$total_paginas = ceil( $cant / $limit_per_page );
		if ( $total_paginas > 1 ) 
		{
			// validamos que no sea la pagina 1 para colocar el link anterior
			if ($pagina != 1)
			{
				$links .= '<a class="link_pagination" data-pagina="1"><i class="fa fa-angle-double-left"></i></a>';
				$links .= '<a class="link_pagination" data-pagina="'.($pagina-1).'"><i class="fa fa-angle-left"></i></a>';
			}
			for ($i=1;$i<=$total_paginas;$i++) {
				// validamos que sea un link anterior a la pagina actual y que sea mayor o igual a 3 paginas atras
				if (  $i >= ($pagina-3) && $i < $pagina )
					$links .= '<a class="link_pagination" data-pagina="'.$i.'">'.$i.'</a>';
            	//si muestro el índice de la página actual, no coloco enlace
				else if ($pagina == $i)
					$links .= '<span class="raleway-bold link_pagination_active">'.$pagina.'</span>';
				// validamos que sea un link siguiente a la pagina actual y que sea menor o igual a 3 paginas adelante
				else if (  $i <= ($pagina+3) && $i > $pagina )
					$links .= '<a class="link_pagination" data-pagina="'.$i.'">'.$i.'</a>';
			}
			// validamos que no sea la ultima pagina para colocar el link siguiente
			if ($pagina != $total_paginas)
			{
				$links .= '<a class="link_pagination" data-pagina="'.($pagina+1).'"><i class="fa fa-angle-right"></i></a>';
				$links .= '<a class="link_pagination" data-pagina="'.$total_paginas.'"><i class="fa fa-angle-double-right"></i></a>';
			}
		}
		// variable que renderiza el listado
		$links .= '
			</div>
		';
		// retornamos el renderizado
		return $links;
	}

	// funcion para arreglar los datos obtenidos por el request del store
	private function fillableStore( $request )
	{
		// contamos cuantos campos se pueden guardar
		$cant = count( $this->fillable );
		// abrimos un parantesis para asignar cuales campos se pueden guardar
		$this->values = ' ( ';
		// recorremos la variable que contiene los campos a guardar
		for ($i=0; $i < $cant; $i++) {
			// asignamos los campos que se pueden guardar
			// dejamos un espacio en blanco para separar los campos
			$this->values .= ' ' . $this->fillable[$i] . ',';
		}
		// eliminamos la coma del ultimo caracter para evitar problemas en la base de datos
		$this->values = $this->deleteLastWord( $this->values );
		// cerramos el parentesis para agregar los valores de los campos que se dejan guardar
		$this->values .= ' ) VALUES ( ';
		// llenamos los valores de los campos
		for ($i=0; $i < $cant; $i++) 
		{
			// validamos que exista algún dato
			if( isset( $request[ $this->fillable[$i] ] ) && !empty( $request[ $this->fillable[$i] ] ) && !is_null( $request[ $this->fillable[$i] ] ) )
				// escapamos la variable para evitar que nos hagan sql injection
				// agreamos los campos que se dejan guardar que provienen del request
				// dejamos un espacio en blanco para separar los campos
				$this->values .= " '". parent::__real_escape_string( $request[ $this->fillable[$i] ] ) ."',";
			else
				// concatenamos como nulo
				$this->values .= "'NULL',";
		}
		// eliminamos la coma del ultimo caracter para evitar problemas en la base de datos
		$this->values = $this->deleteLastWord( $this->values );
		// cerramos el ultimo parentesis
		$this->values .= ' ) ';
	}


	// funcion para arreglar los datos obtenidos por el request del update
	private function fillableUpdate( $request )
	{
		// contamos cuantos campos se pueden guardar
		$cant = count( $this->fillable );
		// limpiamos la variable 
		$this->values = '';
		// recorremos la variable que contiene los campos a guardar
		for ($i=0; $i < $cant; $i++) {
			// validamos que el campo no sea nulo para poder actualizarlo
			if( isset( $request[ $this->fillable[ $i ] ] ) && !empty( $request[ $this->fillable[ $i ] ] ) && !is_null( $request[ $this->fillable[ $i ] ] ) )
				// escapamos la variable para evitar que nos hagan sql injection
				// arreglamos la variable que contiene los campos y valores
				// dejamos un espacio en blanco para separar los campos,
				// luego seleccionamos de la lista el campo que se desea actualizar con la variable fillable
				// luego se asigna el valor que trae la variable request de acuerdo a los campos que se dejan guardar
				$this->values .= " " . $this->fillable[$i] . " = '". parent::__real_escape_string( $request[ $this->fillable[$i] ] ) ."'," ;
		}
		// eliminamos la coma del ultimo caracter para evitar problemas en la base de datos
		$this->values = $this->deleteLastWord( $this->values );
	}

	// funcion para seleccionar los campos que se pueden retornar
	protected function selectInputs()
	{
		// agregamos la llave primaria
		$this->values = $this->primary_key.",";
		// obtenemos una copia de los datos que se pueden guardar
		$fillables = $this->fillable;
		// recorremos el array de los campos que no se dejaran ver
		foreach ( $this->hidden as $hidden ) 
		{
			// preguntamos si existe ese valor en el array de copia
			if( in_array( $hidden, $fillables ) )
				// eliminamos ese valor del array de copia
				unset( $fillables[ array_search( $hidden, $fillables ) ] );
		}
		// recorremos los campos finales para organizar la cadena 
		foreach ($fillables as $data) 
		{
			// organizamos la cadena para ser usada
			$this->values .= " $data,";
		}
		// eliminamos la coma del ultimo caracter para evitar problemas en la base de datos
		$this->values = $this->deleteLastWord( $this->values );
		// retornamos esta cadena para que sea utilizada en otras clases
		return $this->values;
	}

	// función para ocultar los campos ocultos de un array
	// $array: vector de donde eliminaremos los campos ocultos
	private function hide_inputs_hidden( $array )
	{
		foreach ( $this->hidden as $hidden ) 
			// removemos los campos ocultos del array
			unset( $array[ $hidden ] );
		// retornamos el array
		return $array;
	}

	// funcion para eliminar el ultimo caracter de una cadena
	// $str: string a tratar
	private function deleteLastWord( $str )
	{
		// retornamos la cadena sin el último caracter
		return substr($str, 0, -1);
	}

	// función para validar la ejecución la respuesta de una sentencia ejecutada
	private function validate_query( $response )
	{
		// validamos si tenemos un error en la ejecución de la consulta
		if( !$response['status'] )
			// retornamos el mensaje de error
			return $response['message'];
		else
			// retornamos true
			return $response['status'];
	}

}