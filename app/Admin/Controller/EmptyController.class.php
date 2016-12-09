<?php

namespace Admin\Controller;

use Think\Controller;

class EmptyController extends Controller {
	public function _empty() {
		if (APP_DEBUG) {
			$this->e = array (
					'message' => MODULE_NAME . ':' . CONTROLLER_NAME . ':' . ACTION_NAME . ' not exists !' 
			);
		} else {
			$this->e = array (
					'message' => C ( 'ERROR_MESSAGE' ) 
			);
		}
		$this->display ( 'Common@Common:think_exception' );
	}
}