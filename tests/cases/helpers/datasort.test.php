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
		$this->Datasort->params['datasort']['default'] = array(1, 2, 3);
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkTitle() {
		$this->Datasort->params['datasort']['default'] = array(1, 2, 3);
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('id', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('id', 'Test.id');
	}
	
	public function testLinkToggleToAsc() {
		$this->Datasort->params['named']['sort'] = 'Test.id';
		$this->Datasort->params['named']['direction'] = 'desc';
		$this->Datasort->params['named']['page'] = 'default';
		$this->Datasort->params['datasort']['default'] = array(1, 2, 3);
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkToggleToDesc() {
		$this->Datasort->params['named']['sort'] = 'Test.id';
		$this->Datasort->params['named']['direction'] = 'asc';
		$this->Datasort->params['named']['page'] = 'default';
		$this->Datasort->params['datasort']['default'] = array(1, 2, 3);
		
		$sort = 'Test.id';
		$direction = 'desc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkWithDefaultDirection() {
		$this->Datasort->params['datasort']['default'] = array(1, 2, 3);
		
		$sort = 'Test.id';
		$direction = 'desc';
		$page = 'default';
		$limit = '1|2|3';
			
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id', array('direction' => 'desc'));
	}
	
	public function testLinkWithoutLimit() {
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = null;
			
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkWithDefaultDirectionAndNamedParameter() {
		$this->Datasort->params['named']['sort'] = 'Test.id';
		$this->Datasort->params['named']['direction'] = 'desc';
		$this->Datasort->params['named']['page'] = 'default';
		$this->Datasort->params['datasort']['default'] = array(1, 2, 3);
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id', array('direction' => 'desc'));
	}
	
	public function testLinkWithDifferentSortFieldAndNamedParameter() {
		$this->Datasort->params['named']['sort'] = 'Test.id';
		$this->Datasort->params['named']['direction'] = 'asc';
		$this->Datasort->params['named']['page'] = 'default';
		$this->Datasort->params['datasort']['default'] = array(1, 2, 3);
		
		$sort = 'Test.created';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		
		$this->Datasort->link('#', 'Test.created');
	}
	
	public function testLinkWithDefaultDirectionAndHtmlAttributestributes() {
		$this->Datasort->params['datasort']['default'] = array(1, 2, 3);
		
		$sort = 'Test.id';
		$direction = 'desc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array('class' => 'sortlink')));
		$this->Datasort->link('#', 'Test.id', array('direction' => 'desc', 'class' => 'sortlink'));
	}
	
	public function testLinkWithHtmlAttributestributes() {
		$this->Datasort->params['datasort']['default'] = array(1, 2, 3);
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array('class' => 'sortlink')));
		$this->Datasort->link('#', 'Test.id', array('class' => 'sortlink'));
	}
	
	public function endTest() {
		unset($this->Datasort);
	}
}
?>