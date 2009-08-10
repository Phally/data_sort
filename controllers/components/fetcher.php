<?php
class FetcherComponent extends Object {
	
	public $options = array();
	private $defaults = array(
		'session' => false
	);
	
	private $controller = null;
	private $model = null;
	private $session = null;
	
	public function initialize($controller) {
		$this->controller = $controller;
		if (isset($controller->{$controller->modelClass})) {
			$this->model = $controller->{$controller->modelClass};
		}
		$this->session = $controller->Session;
		$controller->helpers[] = 'DataSort.Datasort';
	}
	
	public function fetch($model = null, $page = 'default') {
		if (!$model && !$model = $this->model) {
			return false;
		}
		
		$options = $this->options($page);
		$data = $model->find('all', array_diff_key($options, $this->defaults));
		$this->appendParams($page, $options, Set::extract($data, '/' . $model->alias . '/' . $model->primaryKey));
		
		return $data;
	}
	
	private function appendParams($page, $options, $ids) {
		if (isset($options['limit'])) {
			$this->controller->params['datasort'][$page]['ids'] = $ids;
		} else {
			$this->controller->params['datasort'][$page]['ids'] = null;
		}
		$this->controller->params['datasort'][$page]['session'] = $options['session'];
	}
	
	private function options($page) {
		$params = $this->controller->params;
		$options = isset($this->options[$page]) ? $this->options[$page] : array();
		$options = array_merge($this->defaults, $options);
		
		if ($options['session'] && $session = $this->session->read('DataSort.' . $page)) {
			$options = $session;
		}
		
		if (isset($options['fields']) && !in_array($this->model->primaryKey, $options['fields']) && !in_array($this->model->alias . '.' . $this->model->primaryKey, $options['fields'])) {
			$options['fields'][] = $this->model->alias . '.' . $this->model->primaryKey;
		}
		
		if (isset($params['named']['page']) && isset($params['named']['direction']) && $page == $params['named']['page']) {
			
			if (isset($params['named']['sort'])) {
				$options['order'] = array($params['named']['sort'] => $params['named']['direction']);
			}
		
			if (isset($params['named']['limit']) && is_array($ids = explode('|', $params['named']['limit'])) ) {
				$options['conditions'] = array($this->model->alias . '.' . $this->model->primaryKey => $ids);
			}
			
			if ($options['session']) {
				$this->session->write('DataSort.' . $page, $options);
			}
			
		}
		
		return $options;
	}
}
?>