<?php
class Test extends Model {
}

class TestsController extends Controller {
	public $components = array('DataSort.Fetcher');
}

class FetcherComponentTestCase extends CakeTestCase {
	
	public $fixtures = array('plugin.data_sort.test');
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
	
	public function endTest() {
		unset($this->Tests);
	}
}
?>