<?php

namespace Common\Service;

class ArticleService {
	public function articles_list_by_search($keywords, $cache = 3600, $options = array('limit'=>999)) {
		$flag = 'article/articles_list_by_search/' . $keywords . '/' . md5 ( $cache . serialize ( $options ) );
		$data = S ( $flag );
		if (false === $data) {
			$data = D ( 'Article' )->table ( '__ARTICLE__ a' )->limit ( $options ['limit'] )->join ( '__ARTICLE_CAT__ ac ON a.cat_id=ac.cat_id' )->field ( 'ac.cat_id,ac.url as _ac_url,ac.name,a.art_id,a.posttime,a.url as _a_url,a.title,a.keywords,a.description,a.cover' )->where ( array (
					'a.title' => array (
							'LIKE',
							"%" . str_replace ( "%", '', $keywords ) . "%" 
					) 
			) )->select ();
			if (is_array ( $data )) {
				foreach ( $data as &$v ) {
					$v ['_url'] = __ROOT__ . '/' . ($v ['_ac_url'] ? $v ['_ac_url'] : $v ['cat_id']) . '/' . ($v ['_a_url'] ? $v ['_a_url'] : $v ['art_id']);
				}
			}
			S ( $flag, $data, $cache );
		}
		return $data;
	}
	public function articles_list_by_cat($cat_id, $cache = 3600, $options = array('limit'=>999)) {
		$flag = 'article/articles_list_by_cat/' . $cat_id . '/' . md5 ( $cache . serialize ( $options ) );
		$data = S ( $flag );
		if (false === $data) {
			$data = D ( 'Article' )->table ( '__ARTICLE__ a' )->limit ( $options ['limit'] )->join ( '__ARTICLE_CAT__ ac ON a.cat_id=ac.cat_id' )->field ( 'ac.cat_id,ac.url as _ac_url,ac.name,a.art_id,a.posttime,a.url as _a_url,a.title,a.keywords,a.description,a.cover' )->where ( array (
					'a.cat_id' => $cat_id 
			) )->select ();
			if (is_array ( $data )) {
				foreach ( $data as &$v ) {
					$v ['_url'] = __ROOT__ . '/' . ($v ['_ac_url'] ? $v ['_ac_url'] : $v ['cat_id']) . '/' . ($v ['_a_url'] ? $v ['_a_url'] : $v ['art_id']);
				}
			}
			S ( $flag, $data, $cache );
		}
		return $data;
	}
	public function articles_list_by_ids($ids, $cache = 3600, $options = array()) {
		$flag = 'article/articles_list_by_ids/' . $ids . '/' . md5 ( $cache . serialize ( $options ) );
		$data = S ( $flag );
		if (false === $data) {
			$data = D ( 'Article' )->table ( '__ARTICLE__ a' )->join ( '__ARTICLE_CAT__ ac ON a.cat_id=ac.cat_id' )->field ( 'ac.cat_id,ac.url as _ac_url,ac.name,a.art_id,a.posttime,a.url as _a_url,a.title,a.keywords,a.description,a.cover' )->where ( array (
					'art_id' => array (
							'IN',
							$ids 
					) 
			) )->select ();
			if (is_array ( $data )) {
				foreach ( $data as &$v ) {
					$v ['_url'] = __ROOT__ . '/' . ($v ['_ac_url'] ? $v ['_ac_url'] : $v ['cat_id']) . '/' . ($v ['_a_url'] ? $v ['_a_url'] : $v ['art_id']);
				}
			}
			S ( $flag, $data, $cache );
		}
		return $data;
	}
	public function cats_by_id($cat_ids, $cache = 3600, $options = array('field'=>'*')) {
		$flag = 'article/cats_by_id/' . $cat_ids . '/' . md5 ( $cache . serialize ( $options ) );
		$data = S ( $flag );
		if (false === $data) {
			$data = D ( 'ArticleCat' )->field ( $options ['field'] )->where ( array (
					'cat_id' => array (
							'IN',
							$cat_ids 
					) 
			) )->select ();
			S ( $flag, $data, $cache );
		}
		return $data;
	}
	/**
	 * 获取特定ID的所有子项
	 *
	 * @param integer $specify_child        	
	 * @return array
	 */
	public function cat_texts2($specify_child = -1) {
		$data = $this->cat_nodes ();
		return $this->cat_nodes_texts2 ( $data, '', $specify_child );
	}
	private function cat_nodes_texts2(&$cats_nodes, $spacer = '', $specify_child = -1) {
		$html = array ();
		foreach ( $cats_nodes as &$cat ) {
			if ($specify_child == - 1 || $cat ['cat_id'] == $specify_child) {
				$html [] = array (
						'id' => $cat ['cat_id'],
						'url' => $cat ['url'],
						'name' => $spacer . $cat ['name'] 
				);
				$html = array_merge ( $html, $this->cat_nodes_texts2 ( $cat ['_child'], $spacer . '|-', - 1 ) );
			} else {
				$html = array_merge ( $html, $this->cat_nodes_texts2 ( $cat ['_child'], $spacer . '', $specify_child ) );
			}
		}
		return $html;
	}
	
	/**
	 * 获取除了特定项的所有项
	 *
	 * @param integer $except_child        	
	 * @return array
	 */
	public function cat_texts($except_child = -1) {
		$data = $this->cat_nodes ();
		return $this->cat_nodes_texts ( $data, '', $except_child );
	}
	private function cat_nodes_texts(&$cats_nodes, $spacer = '', $except_child = -1) {
		$html = array ();
		foreach ( $cats_nodes as &$cat ) {
			if ($cat ['cat_id'] == $except_child) {
				continue;
			}
			$html [] = array (
					'id' => $cat ['cat_id'],
					'url' => $cat ['url'],
					'name' => $spacer . $cat ['name'] 
			);
			$html = array_merge ( $html, $this->cat_nodes_texts ( $cat ['_child'], $spacer . '|-', $except_child ) );
		}
		return $html;
	}
	
	/**
	 * 获取所有子项ID，不包含本身
	 *
	 * @param integer $pid        	
	 * @return array
	 */
	public function cat_child_ids($pid) {
		$node = $this->cat_nodes ( $pid );
		return $this->cat_child_ids_merge ( $node );
	}
	private function cat_child_ids_merge(&$node) {
		$ids = array ();
		foreach ( $node as &$v ) {
			$ids [] = $v ['cat_id'];
			if (! empty ( $v ['_child'] )) {
				$ids = array_merge ( $ids, $this->cat_child_ids_merge ( $v ['_child'] ) );
			}
		}
		return $ids;
	}
	
	/**
	 * 获取所有树形结构数组
	 *
	 * @param integer $pid        	
	 * @return array()
	 */
	public function cat_nodes($pid = 0) {
		$datas = D ( 'ArticleCat' )->select ();
		if (is_array ( $datas )) {
			$datas = $this->cat_node_merge ( $datas, $pid );
		} else {
			$datas = array ();
		}
		return $datas;
	}
	private function cat_node_merge(&$node, $pid = 0) {
		$arr = array ();
		
		foreach ( $node as &$v ) {
			if ($v ['pid'] == $pid) {
				$v ['_child'] = $this->cat_node_merge ( $node, $v ['cat_id'] );
				$arr [] = $v;
			}
		}
		tpx_array_sort_by_key ( $arr, 'sort', 'asc' );
		
		return $arr;
	}
}