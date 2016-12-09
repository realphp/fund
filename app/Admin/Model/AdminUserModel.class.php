<?php

namespace Admin\Model;

use Org\Util\String;
use Think\Model\RelationModel;

class AdminUserModel extends RelationModel {
	protected $tableName = 'admin_user';
	protected $fields = array (
			'id',
			'username',
			'password',
			'password_salt',
			'reg_time',
			'reg_ip',
			'last_login_time',
			'last_login_ip',
			'last_change_pwd_time',
			'status' 
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
	
	/**
	 * 返回新添加的用户ID，返回负数表示错误
	 *
	 * @param string $username        	
	 * @param string $password        	
	 * @param number $status        	
	 * @return number Ambigous boolean, string, unknown>
	 */
	public function m_add($username = '', $password = '', $status = 1) {
		if (empty ( $username ) || empty ( $password )) {
			return - 1;
		}
		
		$data = array ();
		$data ['username'] = $username;
		$data ['password'] = $password;
		$data ['password_salt'] = String::randString ( 10 );
		$data ['reg_time'] = time ();
		$data ['reg_ip'] = get_client_ip ( 1, true );
		$data ['last_login_time'] = 0;
		$data ['last_login_ip'] = 0;
		$data ['last_change_pwd_time'] = time ();
		$data ['status'] = $status;
		
		$data ['password'] = encrypt_password ( $data ['password'], $data ['password_salt'] );
		
		if ($this->create ( $data ) && ($insertid = $this->add ())) {
			return $insertid;
		}
		return - 2;
	}
}