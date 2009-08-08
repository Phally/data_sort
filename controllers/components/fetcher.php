<?php
class FetcherComponent extends Object {
	
	public $options = array();
	
	private $controller = null;
	private $model = null;
	
	public function initialize($controller) {
		$this->controller = $controller;
		if (isset($controller->{$controller->modelClass})) {
			$this->model = $controller->{$controller->modelClass};
		}
		$controller->helpers[] = 'DataSort.Datasort';
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