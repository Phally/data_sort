<?php
class DatasortHelper extends AppHelper {

	public $helpers = array('Html');
	
	public $options = array();
	private $defaults = array(
		'sort' => null,
		'direction' => 'asc'
	);
	
	public function link($title, $sort, $options = array()) {
		$this->options = array_merge($this->defaults, $options);
		
		$direction = $this->direction($sort);
		
		$url = compact('sort', 'direction');
		$attributes = array_diff_key($this->options, $this->defaults);
		return $this->Html->link($title, $url, $attributes);
	}
		
	private function direction($sort) {
		if (isset($this->params['named']['direction']) && ($sort == $this->params['named']['sort'])) {
			return $this->toggleDirection($this->params['named']['direction']);
		}
		return $this->options['direction'];
	}
	
	private function toggleDirection($current) {
		return ($current == 'asc') ? 'desc' : 'asc';
	}
	
}
?>