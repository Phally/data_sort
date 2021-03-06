<?php
class Test extends Model {
	public $hasMany = array('AssociatedTest');
}

class AssociatedTest extends Model {
	public $belongsTo = array('Test');
}

class TestsController extends Controller {
	public $components = array('DataSort.Fetcher');
}

class FetcherComponentTestCase extends CakeTestCase {
	
	public $fixtures = array('plugin.data_sort.test', 'plugin.data_sort.associated_test');
	private $Tests = null;
	
	public function startCase() {
		Router::reload();
		App::import('Component', 'Session');
		Mock::generate('SessionComponent');
	}
	
	public function startTest() {
		$this->Tests = new TestsController();
		$this->Tests->constructClasses();
		$this->Tests->Session = new MockSessionComponent();
	}
	
	public function testInstance() {
		$this->assertIsA($this->Tests->Fetcher, 'FetcherComponent', 'Component properly loaded');
	}
	
	public function testInitialize() {
		$this->Tests->Fetcher->initialize($this->Tests);
		$this->assertTrue(in_array('DataSort.Datasort', $this->Tests->helpers), 'Helper properly loaded');
		
		$result = array_keys(Router::getInstance()->named['rules']);
		$expected = array_merge(array('dataset', 'datafield', 'datasort', 'datascope'), Router::getInstance()->named['default']);
		
		$this->assertEqual($result, $expected, 'Named parameters connected to the Router');
	}
	
	public function testFetchWithoutModel() {
		unset($this->Tests->Test);
		$this->Tests->Fetcher->initialize($this->Tests);
		$this->assertFalse($this->Tests->Fetcher->fetch(), 'No model to fetch on');
	}
	
	public function testFetchWithoutParameters() {
		$this->Tests->Fetcher->initialize($this->Tests);
		$data = $this->Tests->Fetcher->fetch();
		
		$result = Set::extract('/Test/id', $data);
		$expected = array(1, 2, 3, 4, 5, 6, 7);
		$this->assertEqual($result, $expected, 'Records complete and in proper order');
	}

	public function testFetchWithModelParameter() {
		$this->Tests->Fetcher->initialize($this->Tests);
		$data = $this->Tests->Fetcher->fetch($this->Tests->Test);
		
		$result = Set::extract('/Test/id', $data);
		$expected = array(1, 2, 3, 4, 5, 6, 7);
		$this->assertEqual($result, $expected, 'Records complete and in proper order');
		
		$data = $this->Tests->Fetcher->fetch($this->Tests->Test->AssociatedTest);
		
		$result = Set::extract('/AssociatedTest/id', $data);
		$expected = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
		$this->assertEqual($result, $expected, 'Records complete and in proper order');
	}
	
	public function testFetchWithOptions() {
		$this->Tests->Fetcher->initialize($this->Tests);
		
		$this->Tests->Fetcher->options = array(
			'default' => array(
				'order' => array('Test.created' => 'DESC'),
				'limit' => 3
			)
		);
		$data = $this->Tests->Fetcher->fetch();
		
		$result = Set::extract('/Test/id', $data);
		$expected = array(5, 4, 3);
		$this->assertEqual($result, $expected, 'Records complete and in proper order');
	}
	
	public function testFetchWithoutIdField() {
		$this->Tests->Fetcher->initialize($this->Tests);
		
		$this->Tests->Fetcher->options = array(
			'default' => array(
				'fields' => array('created'),
				'order' => array('Test.created' => 'DESC'),
				'limit' => 3,
				'recursive' => -1
			)
		);
		$data = $this->Tests->Fetcher->fetch();
		
		$result = Set::extract('/Test/id', $data);
		$expected = array(5, 4, 3);
		$this->assertEqual($result, $expected, 'IDs present in array');
	}
	
	public function testFetchWithOptionsAndNamedParameters() {
		$this->Tests->params['named'] = array(
			'dataset' => 'default',
			'datafield' => 'Test.id',
			'datasort' => 'desc'
		);
		
		$this->Tests->Fetcher->initialize($this->Tests);
		
		$this->Tests->Fetcher->options = array(
			'default' => array(
				'order' => array('Test.created' => 'DESC')
			)
		);
		$data = $this->Tests->Fetcher->fetch();
		$result = Set::extract('/Test/id', $data);
		$expected = array(7, 6, 5, 4, 3, 2, 1);
		$this->assertEqual($result, $expected, 'Records complete and in proper order');
	}
	
	public function testFetchParamsPassing() {
		$this->Tests->Fetcher->initialize($this->Tests);
		$data = $this->Tests->Fetcher->fetch();
		
		$result = $this->Tests->params['datasort']['default']['ids'];
		$this->assertNull($result, 'IDs not placed in Controller::params because \'limit\' is not set');
	}
	
	public function testFetchParamsPassingWithLimit() {
		$this->Tests->Fetcher->initialize($this->Tests);
		$this->Tests->Fetcher->options = array(
			'default' => array(
				'limit' => 5
			)
		);
		$data = $this->Tests->Fetcher->fetch();
		
		$result = $this->Tests->params['datasort']['default']['ids'];
		$expected = Set::extract($data, '/Test/id');
		$this->assertEqual($result, $expected, 'IDs placed in Controller::params');
	}
	
	public function testFetchMultiple() {
		$this->Tests->Fetcher->initialize($this->Tests);
		
		$this->Tests->Fetcher->options = array(
			'resultIdDesc' => array(
				'order' => array('Test.id' => 'desc')
			),
			'resultCreatedDesc' => array(
				'order' => array('Test.created' => 'desc')
			),
			'resultLimited' => array(
				'limit' => 3
			)
		);
		
		$resultIdDesc = $this->Tests->Fetcher->fetch(null, 'resultIdDesc');
		$results = Set::extract($resultIdDesc, '/Test/id');
		$expected = array(7, 6, 5, 4, 3, 2, 1);
		$this->assertEqual($results, $expected, 'First result matches');
		
		$resultCreatedDesc = $this->Tests->Fetcher->fetch(null, 'resultCreatedDesc');
		$results = Set::extract($resultCreatedDesc, '/Test/id');
		$expected = array(5, 4, 3, 1, 2, 6, 7);
		$this->assertEqual($results, $expected, 'Second result matches');
		
		$resultLimited = $this->Tests->Fetcher->fetch(null, 'resultLimited');
		$results = Set::extract($resultLimited, '/Test/id');
		$expected = array(1, 2, 3);
		$this->assertEqual($results, $expected, 'Third result matches');
	}
	
	public function testFetchMultipleWithNamedParameters() {
		$this->Tests->params['named'] = array(
			'dataset' => 'resultLimited',
			'datafield' => 'Test.id',
			'datasort' => 'desc',
			'datascope' => '1|2|3'
		);
		
		$this->Tests->Fetcher->initialize($this->Tests);
		
		$this->Tests->Fetcher->options = array(
			'resultIdDesc' => array(
				'order' => array('Test.id' => 'desc')
			),
			'resultCreatedDesc' => array(
				'order' => array('Test.created' => 'desc')
			),
			'resultLimited' => array(
				'limit' => 3
			)
		);
		
		$resultIdDesc = $this->Tests->Fetcher->fetch(null, 'resultIdDesc');
		$results = Set::extract($resultIdDesc, '/Test/id');
		$expected = array(7, 6, 5, 4, 3, 2, 1);
		$this->assertEqual($results, $expected, 'First result matches');
		
		$resultCreatedDesc = $this->Tests->Fetcher->fetch(null, 'resultCreatedDesc');
		$results = Set::extract($resultCreatedDesc, '/Test/id');
		$expected = array(5, 4, 3, 1, 2, 6, 7);
		$this->assertEqual($results, $expected, 'Second result matches');
		
		$resultLimited = $this->Tests->Fetcher->fetch(null, 'resultLimited');
		$results = Set::extract($resultLimited, '/Test/id');
		$expected = array(3, 2, 1);
		$this->assertEqual($results, $expected, 'Third result matches');
	}
	
	public function testFetchWriteToSession() {
		$this->Tests->params['named'] = array(
			'dataset' => 'default',
			'datafield' => 'Test.id',
			'datasort' => 'asc'
		);
		
		$this->Tests->Fetcher->initialize($this->Tests);
		
		$this->Tests->Fetcher->options = array(
			'default' => array(
				'session' => true,
				'order' => array('Test.id' => 'desc')
			)
		);
		
		$this->Tests->Session->expectOnce('write', array('DataSort.default', array(
			'session' => true,
			'order' => array('Test.id' => 'asc')
		)));
		$this->Tests->Fetcher->fetch();
	}
	
	public function testFetchMultipleWithNamedParametersAndSessionData() {
		$this->Tests->Session->setReturnValue('read', array(
			'session' => true,
			'order' => array('Test.id' => 'asc')
		));
		
		$this->Tests->params['named'] = array(
			'dataset' => 'resultLimited',
			'datafield' => 'Test.id',
			'datasort' => 'desc',
			'datascope' => '1|2|3'
		);
		
		$this->Tests->Fetcher->initialize($this->Tests);
		
		$this->Tests->Fetcher->options = array(
			'resultIdDesc' => array(
				'session' => true,
				'order' => array('Test.id' => 'desc')
			),
			'resultCreatedDesc' => array(
				'order' => array('Test.created' => 'desc')
			),
			'resultLimited' => array(
				'limit' => 3
			)
		);
		
		$this->Tests->Session->expectOnce('read', array('DataSort.resultIdDesc'));
		$resultIdDesc = $this->Tests->Fetcher->fetch(null, 'resultIdDesc');
		$results = Set::extract($resultIdDesc, '/Test/id');
		$expected = array(1, 2, 3, 4, 5, 6, 7);
		$this->assertEqual($results, $expected, 'First result matches');
		
		$resultCreatedDesc = $this->Tests->Fetcher->fetch(null, 'resultCreatedDesc');
		$results = Set::extract($resultCreatedDesc, '/Test/id');
		$expected = array(5, 4, 3, 1, 2, 6, 7);
		$this->assertEqual($results, $expected, 'Second result matches');
		
		$resultLimited = $this->Tests->Fetcher->fetch(null, 'resultLimited');
		$results = Set::extract($resultLimited, '/Test/id');
		$expected = array(3, 2, 1);
		$this->assertEqual($results, $expected, 'Third result matches');
	}
	
	public function endTest() {
		unset($this->Tests);
	}
}
?>