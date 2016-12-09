<?php

namespace Admin\Model;

use Org\Util\String;
use Think\Model\RelationModel;

class PhotoModel extends RelationModel {
	protected $tableName = 'cms_album';
	protected $fields = array (
			'id',
			'description',
			'cover',
			'created_time'
	);
	protected $_validate = array (
			array (
					'username',
					'require',
					'Username Empty OR Replicate',
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
	protected $_link = array (
			'roles' => array (
					'mapping_type' => self::MANY_TO_MANY,
					'class_name' => 'AdminRole',
					'foreign_key' => 'user_id',
					'relation_foreign_key' => 'role_id',
					'relation_table' => '__ADMIN_ROLE_USER__',
					'mapping_order' => '',
					'mapping_limit' => '' 
			) 
	);
	

}