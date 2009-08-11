<?php
class DatasortHelperTestCase extends CakeTestCase {
	
	private $Datasort = null;
	
	public function startCase() {
		App::import('Helper', 'DataSort.Datasort');
		
		App::import('Helper', 'Html');
		App::import('Helper', 'Session');
		Mock::generate('HtmlHelper');
		Mock::generate('SessionHelper');
	}
	
	public function startTest() {
		$this->Datasort = new DatasortHelper();
		$this->Datasort->Html = new MockHtmlHelper();
		$this->Datasort->Session = new MockSessionHelper();
	}
	
	public function testInstance() {
		$this->assertIsA($this->Datasort, 'DatasortHelper', 'Helper properly loaded');
	}
	
	public function testLinkSimple() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkTitle() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('id', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		$this->Datasort->link('id', 'Test.id');
	}
	
	public function testLinkToggleToAsc() {
		$this->Datasort->params['named']['datafield'] = 'Test.id';
		$this->Datasort->params['named']['datasort'] = 'desc';
		$this->Datasort->params['named']['dataset'] = 'default';
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkToggleToDesc() {
		$this->Datasort->params['named']['datafield'] = 'Test.id';
		$this->Datasort->params['named']['datasort'] = 'asc';
		$this->Datasort->params['named']['dataset'] = 'default';
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'desc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkWithDefaultDirection() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'desc';
		$dataset = 'default';
		$datascope = '1|2|3';
			
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		$this->Datasort->link('#', 'Test.id', array('datasort' => 'desc'));
	}
	
	public function testLinkWithoutLimit() {
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = null;
			
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkWithDefaultDirectionAndNamedParameter() {
		$this->Datasort->params['named']['datafield'] = 'Test.id';
		$this->Datasort->params['named']['datasort'] = 'desc';
		$this->Datasort->params['named']['dataset'] = 'default';
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		$this->Datasort->link('#', 'Test.id', array('datasort' => 'desc'));
	}
	
	public function testLinkWithDifferentSortFieldAndNamedParameter() {
		$this->Datasort->params['named']['datafield'] = 'Test.id';
		$this->Datasort->params['named']['datasort'] = 'asc';
		$this->Datasort->params['named']['dataset'] = 'default';
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.created';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		
		$this->Datasort->link('#', 'Test.created');
	}
	
	public function testLinkWithDefaultDirectionAndHtmlAttributestributes() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'desc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array('class' => 'sortlink')));
		$this->Datasort->link('#', 'Test.id', array('datasort' => 'desc', 'class' => 'sortlink'));
	}
	
	public function testLinkWithHtmlAttributestributes() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array('class' => 'sortlink')));
		$this->Datasort->link('#', 'Test.id', array('class' => 'sortlink'));
	}
	
	public function testLinkWithSessionEnabledButNoSessionData() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = true;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkWithSessionEnabledWithSessionDataToAsc() {
		$this->Datasort->Session->setReturnValue('read', array('Test.id' => 'desc'));
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = true;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkWithSessionEnabledWithSessionDataToAscOnDifferentField() {
		$this->Datasort->Session->setReturnValue('read', array('Test.created' => 'desc'));
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = true;
		
		$datafield = 'Test.id';
		$datasort = 'desc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		$this->Datasort->link('#', 'Test.id', array('datasort' => 'desc'));
	}
	
	public function testLinkWithSessionEnabledWithSessionDataToDesc() {
		$this->Datasort->Session->setReturnValue('read', array('Test.id' => 'asc'));
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = true;
		
		$datafield = 'Test.id';
		$datasort = 'desc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('datafield', 'datasort', 'dataset', 'datascope'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testOptionsWithoutOverride() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$this->Datasort->options(array('class' => 'sortlink'));
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('id', compact('datafield', 'datasort', 'dataset', 'datascope'), array('class' => 'sortlink')));
		$this->Datasort->link('id', 'Test.id');
	}
	
	public function testOptionsWithOverride() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->options(array('class' => 'sortlink'));
		$this->Datasort->Html->expectOnce('link', array('id', compact('datafield', 'datasort', 'dataset', 'datascope'), array('class' => 'customclass')));
		$this->Datasort->link('id', 'Test.id', array('class' => 'customclass'));
	}
	
	public function testLinkWithAnchor() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('id', array_merge(compact('datafield', 'datasort', 'dataset', 'datascope'), array('#' => 'default_test_id')), array('name' => 'default_test_id')));
		$this->Datasort->link('id', 'Test.id', array('anchor' => true));
	}
	
	public function testLinkWithGlobalAnchor() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('id', array_merge(compact('datafield', 'datasort', 'dataset', 'datascope'), array('#' => 'default_test_id')), array('name' => 'default_test_id')));
		$this->Datasort->options(array('anchor' => true));
		$this->Datasort->link('id', 'Test.id');
	}
	
	public function testLinkWithGlobalUrl() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$datafield = 'Test.id';
		$datasort = 'asc';
		$dataset = 'default';
		$datascope = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('id', array_merge(array(4, 'some' => 'param'), compact('datafield', 'datasort', 'dataset', 'datascope')), array()));
		$this->Datasort->options(array('url' => array(4, 'some' => 'param')));
		$this->Datasort->link('id', 'Test.id');
	}
	
	public function endTest() {
		unset($this->Datasort);
	}
}
?>