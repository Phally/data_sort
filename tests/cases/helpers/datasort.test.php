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
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkTitle() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
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
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
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
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$sort = 'Test.id';
		$direction = 'desc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkWithDefaultDirection() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$sort = 'Test.id';
		$direction = 'desc';
		$page = 'default';
		$limit = '1|2|3';
			
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id', array('direction' => 'desc'));
	}
	
	public function testLinkWithoutLimit() {
		$this->Datasort->params['datasort']['default']['session'] = false;
		
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
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
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
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$sort = 'Test.created';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		
		$this->Datasort->link('#', 'Test.created');
	}
	
	public function testLinkWithDefaultDirectionAndHtmlAttributestributes() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$sort = 'Test.id';
		$direction = 'desc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array('class' => 'sortlink')));
		$this->Datasort->link('#', 'Test.id', array('direction' => 'desc', 'class' => 'sortlink'));
	}
	
	public function testLinkWithHtmlAttributestributes() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array('class' => 'sortlink')));
		$this->Datasort->link('#', 'Test.id', array('class' => 'sortlink'));
	}
	
	public function testLinkWithSessionEnabledButNoSessionData() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = true;
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkWithSessionEnabledWithSessionDataToAsc() {
		$this->Datasort->Session->setReturnValue('read', array('Test.id' => 'desc'));
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = true;
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testLinkWithSessionEnabledWithSessionDataToAscOnDifferentField() {
		$this->Datasort->Session->setReturnValue('read', array('Test.created' => 'desc'));
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = true;
		
		$sort = 'Test.id';
		$direction = 'desc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id', array('direction' => 'desc'));
	}
	
	public function testLinkWithSessionEnabledWithSessionDataToDesc() {
		$this->Datasort->Session->setReturnValue('read', array('Test.id' => 'asc'));
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = true;
		
		$sort = 'Test.id';
		$direction = 'desc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('#', compact('sort', 'direction', 'page', 'limit'), array()));
		$this->Datasort->link('#', 'Test.id');
	}
	
	public function testOptionsWithoutOverride() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$this->Datasort->options(array('class' => 'sortlink'));
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('id', compact('sort', 'direction', 'page', 'limit'), array('class' => 'sortlink')));
		$this->Datasort->link('id', 'Test.id');
	}
	
	public function testOptionsWithOverride() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->options(array('class' => 'sortlink'));
		$this->Datasort->Html->expectOnce('link', array('id', compact('sort', 'direction', 'page', 'limit'), array('class' => 'customclass')));
		$this->Datasort->link('id', 'Test.id', array('class' => 'customclass'));
	}
	
	public function testLinkWithAnchor() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('id', array_merge(compact('sort', 'direction', 'page', 'limit'), array('#' => 'default_test_id')), array('name' => 'default_test_id')));
		$this->Datasort->link('id', 'Test.id', array('anchor' => true));
	}
	
	public function testLinkWithGlobalAnchor() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('id', array_merge(compact('sort', 'direction', 'page', 'limit'), array('#' => 'default_test_id')), array('name' => 'default_test_id')));
		$this->Datasort->options(array('anchor' => true));
		$this->Datasort->link('id', 'Test.id');
	}
	
	public function testLinkWithGlobalUrl() {
		$this->Datasort->params['datasort']['default']['ids'] = array(1, 2, 3);
		$this->Datasort->params['datasort']['default']['session'] = false;
		
		$sort = 'Test.id';
		$direction = 'asc';
		$page = 'default';
		$limit = '1|2|3';
		
		$this->Datasort->Html->expectOnce('link', array('id', array_merge(array(4, 'some' => 'param'), compact('sort', 'direction', 'page', 'limit')), array()));
		$this->Datasort->options(array('url' => array(4, 'some' => 'param')));
		$this->Datasort->link('id', 'Test.id');
	}
	
	public function endTest() {
		unset($this->Datasort);
	}
}
?>