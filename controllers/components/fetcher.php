<?php
class FetcherComponent extends Object {
	
	// public $params = array();
	public $options = array();
	
	private $model = null;
	
	public function initialize($controller) {
		if (isset($controller->{$controller->modelClass})) {
			$this->model = $controller->{$controller->modelClass};
		}
		// $this->params = $controller->params;
	}
	
	public function fetch($model = null) {
		if (!$model && !$model = $this->model) {
			return false;
		}
		
		$options = $this->options;
		
		return $model->find('all', $options);
	}
}
?>