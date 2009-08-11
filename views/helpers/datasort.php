<?php
/**
 * DatasortHelper for DataSort plugin.
 *
 * Generates sort links.
 *
 * @author Frank de Graaf (Phally)
 * @link http://wiki.github.com/Phally/data_sort
 */
class DatasortHelper extends AppHelper {

/**
 * Helper this Helper uses.
 * 
 * @var array (default: array())
 * @access public
 */
	public $helpers = array('Html', 'Session');

/**
 * Holds options used for single link.
 * 
 * @var array (default: array())
 * @access private
 */
	private $options = array();

/**
 * Holds options used for all links.
 * 
 * @var array (default: array())
 * @access private
 */
	private $globals = array();
	
/**
 * Holds default value for options.
 * 
 * @var array (default: array())
 * @access private
 */
	private $defaults = array(
		
		// Whether to use anchors in the links or not (boolean):
		'anchor' => false,
		
		// Default sort direction:
		'datasort' => 'asc',
		
		// Default dataset key:
		'dataset' => 'default',
		
		// Default sort field:
		'datafield' => null,
		
		// Default URL addition (used to append View::$passedArgs):
		'url' => array()
	);

/**
 * Method to generate a sort link.
 * 
 * @param string $title Text for the link.
 * @param string $datafield Model field to sort on. (notation: Model.field)
 * @param array $options List of options that override the (defaul) global options and/or add HTML attributes.
 * @return string The rendered link.
 * @access public
 */
	public function link($title, $datafield, $options = array()) {
		// Merge all options:
		$this->options = array_merge($this->defaults, $this->globals, $options);
		
		// Get the dataset key:
		$dataset = $this->options['dataset'];
		
		// Get the sort direction for this link:
		$datasort = $this->datasort($datafield, $dataset);
		
		// Check if the ids are set in the params:
		if (!empty($this->params['datasort'][$dataset]['ids'])) {
		
			// Set the list of ids as the limit (scope) for this link:
			$datascope = implode('|', $this->params['datasort'][$dataset]['ids']);
			
		} else {
			
			// Set no limit (scope):
			$datascope = null;
			
		}
		
		// Compile the URL array:
		$url = array_merge($this->options['url'], compact('datafield', 'datasort', 'dataset', 'datascope'));
		
		// Compile the HTML attributes array:
		$attributes = array_diff_key($this->options, $this->defaults);
		
		// Check if this link needs an anchor:
		if ($this->options['anchor']) {
			
			// Generate the anchor name:
			$name = strtolower(Inflector::slug($dataset . ' ' . $datafield));
			
			// Append the name attribute to the link:
			$attributes = array_merge($attributes, compact('name'));
			
			// Append the name as anchor the to link:
			$url = array_merge($url, array('#' => $name));
		}
		
		// Render and return the link:
		return $this->Html->link($title, $url, $attributes);
	}

/**
 * Method to set global options.
 * 
 * @param array $options List of options to use a default options for every link.
 * @return void
 * @access public
 */ 
	public function options($options) {
	
		// Set the given options as global options:
		$this->globals = $options;
		
	}

/**
 * Method to determine the sort direction.
 * 
 * @param string $datafield Model field to sort on. (notation: Model.field)
 * @param string $dataset The key of the current dataset.
 * @return string 'asc' or 'desc'.
 * @access private
 */
	private function datasort($datafield, $dataset) {
	
		// Check if all the named params are set for a unique sort field:
		if (isset($this->params['named']['datasort']) && isset($this->params['named']['datafield']) && isset($this->params['named']['dataset'])) {
		
			// Check if the field and the dataset matches the named params:
			if ($datafield == $this->params['named']['datafield'] && $dataset == $this->params['named']['dataset']) {
			
				// Toggle and return the direction:
				return $this->toggleDatasort($this->params['named']['datasort']);
				
			}
			
		} 
		
		
		// Check if the session needs to be used:
		if ($this->params['datasort'][$dataset]['session']) {
		
			// Check if the order is set in the session:
			if ($order = $this->Session->read('DataSort.' . $dataset . '.order')) {
			
				// Check if the field matches:
				if (key($order) == $datafield) {
					
					// Toggle and return the direction:
					return $this->toggleDatasort(current($order));
					
				}
				
			}
			
		}
		
		// If nothing is toggled, return the default direction:
		return $this->options['datasort'];
		
	}

/**
 * Method to toggle directions.
 * 
 * @param string $current Begin sort state. ('asc' or 'desc')
 * @return string 'asc' or 'desc', the opposite of $current.
 * @access private
 */ 
	private function toggleDatasort($current) {
	
		// Check if the current direction is asc, then return desc, else return asc:
		return ($current == 'asc') ? 'desc' : 'asc';
		
	}
	
}
?>