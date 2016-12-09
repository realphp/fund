<?php

namespace Admin\Model;

use Think\Model;

class AdminRoleModel extends Model {
	protected $tableName = 'admin_node';
	protected $fields = array (
			'id',
			'name',
			'title',
			'status',
			'sort',
			'pid',
			'level' 
	);
	protected $_validate = array (
			array (
					'name',
					'require',
					'{%node_name_desc}' 
			),
			array (
					'status',
					array (
							0,
							1 
					),
					'Status Invalid',
					self::MUST_VALIDATE,
					'in',
					self::MODEL_BOTH 
			) 
	);
	protected $pk = 'id';
}