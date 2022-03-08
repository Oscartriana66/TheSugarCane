<?php 


class Generate extends Model
{

	public function __construct()
	{
		// llamamos el contructor de la clase padre
		parent::__construct();
	}

	public function customer( $sql, $fetch = NULL )
	{
		return parent::customer( $sql );
	}

}