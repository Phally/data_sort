<?php
class DatasortHelper extends AppHelper {

	public $helpers = array('Html', 'Session');
	
	public $options = array();
	private $defaults = array(
		'sort' => null,
		'direction' => 'asc',
		'page' => 'default'
	);
	
	public function link($title, $sort, $options = array()) {
		$this->options = array_merge($this->defaults, $options);
		
		$page = $this->options['page'];
		$direction = $this->direction($sort, $page);

		if (!empty($this->params['datasort'][$page]['ids'])) {
			$limit = implode('|', $this->params['datasort'][$page]['ids']);
		} else {
			$limit = null;
		}
		
		$url = compact('sort', 'direction', 'page', 'limit');
		$attributes = array_diff_key($this->options, $this->defaults);
		return $this->Html->link($title, $url, $attributes);
	}
		
	private function direction($sort, $page) {
		if (isset($this->params['named']['direction']) && isset($this->params['named']['sort']) && isset($this->params['named']['page'])) {
			if ($sort == $this->params['named']['sort'] && $page == $this->params['named']['page']) {
				return $this->toggleDirection($this->params['named']['direction']);
			}
		} 
		
		if ($this->params['datasort'][$page]['session']) {
			if ($order = $this->Session->read('DataSort.' . $page . '.order')) {
				if (key($order) == $sort) {
					return $this->toggleDirection(current($order));
				}
			}
		}
		return $this->options['direction'];
	}
	
	private function toggleDirection($current) {
		return ($current == 'asc') ? 'desc' : 'asc';
	}
	
}
?>