<?php
class DatasortHelperTestCase extends CakeTestCase {
	
	private $Datasort = null;
	
	public function startCase() {
		App::import('Helper', 'DataSort.Datasort');
		
		App::import('Helper', 'Html');
		Mock::generate('HtmlHelper');
	}
	
	public function startTest() {
		$this->Datasort = new DatasortHelper();
		$this->Datasort->Html = new MockHtmlHelper();
	}
	
	public function testInstance() {
		$this->assertIsA($this->Datasort, 'DatasortHelper', 'Helper properly loaded');
	}
	
	public function testLinkSimple() {
		$this->Datasort->Html->expectOnce('link', array('#', array('sort' => 'Test.id', 'direction' => 'asc'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkTitle() {
		$this->Datasort->Html->expectOnce('link', array('id', array('sort' => 'Test.id', 'direction' => 'asc'), array()));
		$this->Datasort->link('id', 'Test.id');
	}
	
	public function testLinkToggleToAsc() {
		$this->Datasort->Html->expectOnce('link', array('#', array('sort' => 'Test.id', 'direction' => 'asc'), array()));
		$this->Datasort->params['named']['sort'] = 'Test.id';
		$this->Datasort->params['named']['direction'] = 'desc';
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkToggleToDesc() {
		$this->Datasort->Html->expectOnce('link', array('#', array('sort' => 'Test.id', 'direction' => 'desc'), array()));
		$this->Datasort->params['named']['sort'] = 'Test.id';
		$this->Datasort->params['named']['direction'] = 'asc';
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkWithDefaultDirection() {
		$this->Datasort->Html->expectOnce('link', array('#', array('sort' => 'Test.id', 'direction' => 'desc'), array()));
		$this->Datasort->link('#', 'Test.id', array('direction' => 'desc'));
	}
	
	public function testLinkWithDefaultDirectionAndNamedParameter() {
		$this->Datasort->Html->expectOnce('link', array('#', array('sort' => 'Test.id', 'direction' => 'asc'), array()));
		$this->Datasort->params['named']['sort'] = 'Test.id';
		$this->Datasort->params['named']['direction'] = 'desc';
		$this->Datasort->link('#', 'Test.id', array('direction' => 'desc'));
	}
	
	public function testLinkWithDifferentSortFieldAndNamedParameter() {
		$this->Datasort->Html->expectOnce('link', array('#', array('sort' => 'Test.created', 'direction' => 'asc'), array()));
		$this->Datasort->params['named']['sort'] = 'Test.id';
		$this->Datasort->params['named']['direction'] = 'asc';
		$this->Datasort->link('#', 'Test.created');
	}
	
	public function testLinkWithDefaultDirectionAndHtmlAttributestributes() {
		$this->Datasort->Html->expectOnce('link', array('#', array('sort' => 'Test.id', 'direction' => 'desc'), array('class' => 'sortlink')));
		$this->Datasort->link('#', 'Test.id', array('direction' => 'desc', 'class' => 'sortlink'));
	}
	
	public function testLinkWithHtmlAttributestributes() {
		$this->Datasort->Html->expectOnce('link', array('#', array('sort' => 'Test.id', 'direction' => 'asc'), array('class' => 'sortlink')));
		$this->Datasort->link('#', 'Test.id', array('class' => 'sortlink'));
	}
	
	public function endTest() {
		unset($this->Datasort);
	}
}
?>