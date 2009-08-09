<?php
class FetcherComponent extends Object {
	
	public $options = array();
	
	private $controller = null;
	private $model = null;
	
	private $defaults = array(
		'page' => 'default'
	);
	
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
		
		$options = $this->options();
		
		$page = isset($options['page']) ? $options['page'] : 'default';
		unset($options['page']);
		
		$data = $model->find('all', $options);
		$this->appendParams($page, Set::extract($data, '/' . $model->alias . '/' . $model->primaryKey));
		
		return $data;
	}
	
	private function appendParams($page, $ids) {
		if (isset($this->options['limit'])) {
			$this->controller->params['datasort'][$page] = $ids;
		} else {
			$this->controller->params['datasort'][$page] = null;
		}
	}
	
	private function options() {
		$params = $this->controller->params;
		$options = array_merge($this->defaults, $this->options);
		
		if (isset($options['fields']) && !in_array($this->model->primaryKey, $options['fields']) && !in_array($this->model->alias . '.' . $this->model->primaryKey, $options['fields'])) {
			$options['fields'][] = $this->model->alias . '.' . $this->model->primaryKey;
		}
		
		if (isset($params['named']['page']) && isset($params['named']['direction']) && $options['page'] == $params['named']['page']) {
			
			if (isset($params['named']['sort'])) {
				$options['order'] = array($params['named']['sort'] => $params['named']['direction']);
			}
		
			if (isset($params['named']['limit']) && is_array($ids = explode('|', $params['named']['limit'])) ) {
				$options['conditions'] = array($this->model->alias . '.' . $this->model->primaryKey => $ids);
			}
			
		}
		
		return $options;
	}
}
?>