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
		'direction' => 'asc',
		
		// Default dataset key:
		'page' => 'default',
		
		// Default sort field:
		'sort' => null,
		
		// Default URL addition (used to append View::$passedArgs):
		'url' => array()
	);

/**
 * Method to generate a sort link.
 * 
 * @param string $title Text for the link.
 * @param string $sort Model field to sort on. (notation: Model.field)
 * @param array $options List of options that override the (defaul) global options and/or add HTML attributes.
 * @return string The rendered link.
 * @access public
 */
	public function link($title, $sort, $options = array()) {
		// Merge all options:
		$this->options = array_merge($this->defaults, $this->globals, $options);
		
		// Get the dataset key:
		$page = $this->options['page'];
		
		// Get the sort direction for this link:
		$direction = $this->direction($sort, $page);
		
		// Check if the ids are set in the params:
		if (!empty($this->params['datasort'][$page]['ids'])) {
		
			// Set the list of ids as the limit (scope) for this link:
			$limit = implode('|', $this->params['datasort'][$page]['ids']);
			
		} else {
			
			// Set no limit (scope):
			$limit = null;
			
		}
		
		// Compile the URL array:
		$url = array_merge($this->options['url'], compact('sort', 'direction', 'page', 'limit'));
		
		// Compile the HTML attributes array:
		$attributes = array_diff_key($this->options, $this->defaults);
		
		// Check if this link needs an anchor:
		if ($this->options['anchor']) {
			
			// Generate the anchor name:
			$name = strtolower(Inflector::slug($page . ' ' . $sort));
			
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
 * @param string $sort Model field to sort on. (notation: Model.field)
 * @param string $page The key of the current dataset.
 * @return string 'asc' or 'desc'.
 * @access private
 */
	private function direction($sort, $page) {
	
		// Check if all the named params are set for a unique sort field:
		if (isset($this->params['named']['direction']) && isset($this->params['named']['sort']) && isset($this->params['named']['page'])) {
		
			// Check if the field and the dataset matches the named params:
			if ($sort == $this->params['named']['sort'] && $page == $this->params['named']['page']) {
			
				// Toggle and return the direction:
				return $this->toggleDirection($this->params['named']['direction']);
				
			}
			
		} 
		
		
		// Check if the session needs to be used:
		if ($this->params['datasort'][$page]['session']) {
		
			// Check if the order is set in the session:
			if ($order = $this->Session->read('DataSort.' . $page . '.order')) {
			
				// Check if the field matches:
				if (key($order) == $sort) {
					
					// Toggle and return the direction:
					return $this->toggleDirection(current($order));
					
				}
				
			}
			
		}
		
		// If nothing is toggled, return the default direction:
		return $this->options['direction'];
		
	}

/**
 * Method to toggle directions.
 * 
 * @param string $current Begin sort state. ('asc' or 'desc')
 * @return string 'asc' or 'desc', the opposite of $current.
 * @access private
 */ 
	private function toggleDirection($current) {
	
		// Check if the current direction is asc, then return desc, else return asc:
		return ($current == 'asc') ? 'desc' : 'asc';
		
	}
	
}
?>