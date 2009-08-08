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
	
	public function startTest() {
		$this->Tests = new TestsController();
		$this->Tests->constructClasses();
	}
	
	public function testInstance() {
		$this->assertIsA($this->Tests->Fetcher, 'FetcherComponent', 'Component properly loaded');
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
		$this->assertEqual($result, $expected, 'Records complete and in proper order.');
	}

	public function testFetchWithModelParameter() {
		$this->Tests->Fetcher->initialize($this->Tests);
		$data = $this->Tests->Fetcher->fetch($this->Tests->Test);
		
		$result = Set::extract('/Test/id', $data);
		$expected = array(1, 2, 3, 4, 5, 6, 7);
		$this->assertEqual($result, $expected, 'Records complete and in proper order.');
		
		$data = $this->Tests->Fetcher->fetch($this->Tests->Test->AssociatedTest);
		
		$result = Set::extract('/AssociatedTest/id', $data);
		$expected = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
		$this->assertEqual($result, $expected, 'Records complete and in proper order.');
	}
	
	public function testFetchWithOptions() {
		$this->Tests->Fetcher->initialize($this->Tests);
		
		$this->Tests->Fetcher->options = array(
			'order' => array('Test.created' => 'DESC'),
			'limit' => 3
		);
		$data = $this->Tests->Fetcher->fetch();
		
		$result = Set::extract('/Test/id', $data);
		$expected = array(5, 4, 3);
		$this->assertEqual($result, $expected, 'Records complete and in proper order.');
	}
	
	public function endTest() {
		unset($this->Tests);
	}
}
?>