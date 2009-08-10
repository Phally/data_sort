<?php
/**
 * FetcherComponent for DataSort plugin.
 *
 * Fetches data using given options and parameters.
 *
 * @author Frank de Graaf (Phally)
 * @link http://wiki.github.com/Phally/data_sort
 */
class FetcherComponent extends Object {
	
/**
 * Holds options to use for fetching.
 * 
 * @var array (default: array())
 * @access public
 */
	public $options = array();
	
/**
 * Holds default options.
 * 
 * @var array (default: array())
 * @access private
 */
	private $defaults = array(
		'session' => false
	);

/**
 * Reference to the current Controller.
 * 
 * @var object (default: null)
 * @access private
 */
	private $controller = null;
	
/**
 * Reference to the Model used for fetching.
 * 
 * @var object (default: null)
 * @access private
 */
	private $model = null;
	
/**
 * Reference to the SessionComponent.
 * 
 * @var object (default: null)
 * @access private
 */
	private $session = null;

/**
 * Callback method to initialize the FetcherComponent.
 *
 * @param object $controller Instance of the current controller.
 * @return void
 * @access public
 */ 
	public function initialize($controller) {
		
		// Set controller reference:
		$this->controller = $controller;
		
		// Check if the current Controller has a default model:
		if (isset($controller->{$controller->modelClass})) {
			
			// Set the Model reference to the default Model of this Controller:
			$this->model = $controller->{$controller->modelClass};
			
		}
		
		// Set the reference to the SessionComponent:
		$this->session = $controller->Session;
		
		// Add the Datasort helper, so it can be used in the View.
		$controller->helpers[] = 'DataSort.Datasort';
		
	}

/**
 * Method to get data.
 * 
 * @param object $model Model to fetch on, if non given the default Model for the Controller is used.
 * @param string $page Key in the FetcherComponent::$options variable to use as config for this fetch.
 * @return array The found data.
 * @access public
 */ 
	public function fetch($model = null, $page = 'default') {
	
		// Check if there is a Model to fetch on or get the default Model:
		if (!$model && !$model = $this->model) {
		
			// No Model found, no use to continue:
			return false;
			
		}
		
		// Get the fetch options:
		$options = $this->options($page);
		
		// Fetch the data from the model, using the options minus the specific options for this Component:
		$data = $model->find('all', array_diff_key($options, $this->defaults));
		
		// Set the parameters for further use in the Helper/View:
		$this->appendParams($page, $options, Set::extract($data, '/' . $model->alias . '/' . $model->primaryKey));
		
		// Return the data to the Controller:
		return $data;
		
	}

/**
 * Method to add parameters to the Controller to eventually pass on to the View.
 * 
 * @param string $page Key in the FetcherComponent::$options variable which is used to identify a specific set of parameters.
 * @param array $options Options to use to get parameter settings from.
 * @param array $ids List of primary keys of the fetched model to use as scope for the next request.
 * @return void
 * @access private
 */ 
	private function appendParams($page, $options, $ids) {
	
		// Check if a limit is set:
		if (isset($options['limit'])) {
		
			// Limit is set, pass list of ids to the View/Helper:
			$this->controller->params['datasort'][$page]['ids'] = $ids;
			
		} else {
		
			// Limit is not set, don't pass the list, but set the key:
			$this->controller->params['datasort'][$page]['ids'] = null;
		}
		
		// Pass the boolean to trigger the helper to use the session:
		$this->controller->params['datasort'][$page]['session'] = $options['session'];
		
	}

/**
 * Method to configure the options for the current fetch and places them in the session (if specified).
 * 
 * @param string $page Key in the FetcherComponent::$options variable which is used to identify a specific set of options.
 * @return array Configured list of options to use for the current fetch.
 * @access private
 */ 	
	private function options($page) {
	
		// Shortcut to the current params:
		$params = $this->controller->params;
		
		// Check if any options are set, else set an empty array to prevent errors when merging with defaults:
		$options = isset($this->options[$page]) ? $this->options[$page] : array();
		
		// Merge the options with the defaults, so all needed keys are set:
		$options = array_merge($this->defaults, $options);
		
		// Check if the session needs to be used and if the session contains a set of options:
		if ($options['session'] && $session = $this->session->read('DataSort.' . $page)) {
			
			// The session contains options, use these instead:
			$options = $session;

		}
		
		// Check if the fields option is set and whether it contains the primary key:
		if (isset($options['fields']) && !in_array($this->model->primaryKey, $options['fields']) && !in_array($this->model->alias . '.' . $this->model->primaryKey, $options['fields'])) {
		
			// The primary key isn't set in field, appending it:
			$options['fields'][] = $this->model->alias . '.' . $this->model->primaryKey;
			
		}
		
		// Check if the page matches the current option set and if the direction is set:
		if (isset($params['named']['page']) && isset($params['named']['direction']) && $page == $params['named']['page']) {
			
			// Check if the named parameter for the sort value is set:
			if (isset($params['named']['sort'])) {
				
				// Change the order to what is given in the named parameters:
				$options['order'] = array($params['named']['sort'] => $params['named']['direction']);
				
			}
			
			// Check if the named parameter for limit is set and if it contains an array of ids:
			if (isset($params['named']['limit']) && is_array($ids = explode('|', $params['named']['limit'])) ) {
			
				// Replace the conditions to only get the ids in the limit:
				$options['conditions'] = array($this->model->alias . '.' . $this->model->primaryKey => $ids);
				
			}
			
			// Check if the session needs to be used:
			if ($options['session']) {
			
				// Write the options to the session:
				$this->session->write('DataSort.' . $page, $options);
				
			}
			
		}
		
		// Return the ajusted array of options:
		return $options;
		
	}
}
?>