<?php

namespace Admin\Controller;

class ModController extends AdminController {
	protected $build_db = null;
	protected $build_db_prefix = null;
	protected $build_db_type = null;
	public function build($yummy = false) {
		$this->build_db = \Think\Db::getInstance ();
		$this->build_db_prefix = C ( 'DB_PREFIX' );
		$this->build_db_type = C ( 'DB_TYPE' );
	}
	protected function build_success($yummy = false) {
		if (! $yummy) {
			$this->success ( L ( 'build_success' ) );
		}
	}
	/**
	 * 判断一个表是否存在于数据库
	 *
	 * @param string $table        	
	 */
	protected function build_table_exists($table) {
		static $tables = null;
		static $db_prefix = null;
		
		if (! $this->build_db) {
			return true;
		}
		if (null === $tables) {
			$tables = $this->build_db->getTables ();
			$db_prefix = C ( 'DB_PREFIX' );
		}
		
		if (in_array ( $db_prefix . $table, $tables )) {
			return true;
		}
		return false;
	}
}