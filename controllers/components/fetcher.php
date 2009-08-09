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
		
		$data = $model->find('all',  $this->options());
		$this->appendParams(Set::extract($data, '/' . $model->alias . '/' . $model->primaryKey));
		
		return $data;
	}
	
	private function appendParams($ids) {
		if (isset($this->options['limit'])) {
			$this->controller->params['datasort']['default'] = $ids;
		} else {
			$this->controller->params['datasort']['default'] = null;
		}
	}
	
	private function options() {
		$params = $this->controller->params;
		$options = $this->options;
		
		if (isset($params['named']['sort']) && isset($params['named']['direction'])) {
			$options['order'] = array($params['named']['sort'] => $params['named']['direction']);
		}
		
		if (isset($options['fields']) && !in_array($this->model->primaryKey, $options['fields']) && !in_array($this->model->alias . '.' . $this->model->primaryKey, $options['fields'])) {
			$options['fields'][] = $this->model->alias . '.' . $this->model->primaryKey;
		}
		
		if (isset($params['named']['limit']) && is_array($ids = explode('|', $params['named']['limit']))) {
			$options['conditions'] = array($this->model->alias . '.' . $this->model->primaryKey => $ids);
		}
		
		return $options;
	}
}
?>