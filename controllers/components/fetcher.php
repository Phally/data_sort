<?php
class FetcherComponent extends Object {
	
	// public $params = array();
	
	private $model = null;
	
	public function initialize($controller) {
		if (isset($controller->{$controller->modelClass})) {
			$this->model = $controller->{$controller->modelClass};
		}
		// $this->params = $controller->params;
	}
	
	public function fetch($model = null, $options = array()) {
		if (!$model && !$model = $this->model) {
			return false;
		}
		
		return $model->find('all', $options);
	}
}
?>