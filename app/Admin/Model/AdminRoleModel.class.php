<?php

namespace Admin\Model;

use Think\Model;

class AdminRoleModel extends Model {
	protected $tableName = 'admin_role';
	protected $fields = array (
			'id',
			'name',
			'pid',
			'status' 
	);
	protected $_validate = array (
			array (
					'name',
					'require',
					'Name Empty OR Replicate',
					self::MUST_VALIDATE,
					'unique',
					self::MODEL_BOTH 
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