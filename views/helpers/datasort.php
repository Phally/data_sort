<?php
class DatasortHelper extends AppHelper {

	public $helpers = array('Html');
	
	public $options = array();
	private $defaults = array(
		'direction' => 'asc'
	);
	
	public function link($title, $sort, $options = array()) {
		$this->options = array_merge($this->defaults, $options);
		
		$direction = $this->direction();
		
		$url = compact('sort', 'direction');
		$attributes = array_diff_key($this->options, $this->defaults);
		return $this->Html->link($title, $url, $attributes);
	}
		
	private function direction() {
		if (isset($this->params['named']['direction'])) {
			return $this->toggleDirection($this->params['named']['direction']);
		}
		return $this->options['direction'];
	}
	
	private function toggleDirection($current) {
		return ($current == 'asc') ? 'desc' : 'asc';
	}
	
}
?>