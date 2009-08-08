<?php
class DatasortHelperTestCase extends CakeTestCase {
	
	private $Datasort = null;
	
	public function startCase() {
		App::import('Helper', 'DataSort.Datasort');
	}
	
	public function startTest() {
		$this->Datasort = new DatasortHelper();
	}
	
	public function testInstance() {
		$this->assertIsA($this->Datasort, 'DatasortHelper', 'Helper properly loaded');
	}
	
	public function endTest() {
		unset($this->Datasort);
	}
}
?>