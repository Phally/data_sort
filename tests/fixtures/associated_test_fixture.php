<?php
class AssociatedTestFixture extends CakeTestFixture {
	public $table = 'associated_tests';
	
	public $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'title' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 2),
		'test_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	
	public $records = array(
		array('id' => 1, 'title' => 'AAA', 'test_id' => 1),
		array('id' => 2, 'title' => 'BBB', 'test_id' => 1),
		array('id' => 3, 'title' => 'CCC', 'test_id' => 2),
		array('id' => 4, 'title' => 'EEE', 'test_id' => 3),
		array('id' => 5, 'title' => 'FFF', 'test_id' => 3),
		array('id' => 6, 'title' => 'GGG', 'test_id' => 4),
		array('id' => 7, 'title' => 'HHH', 'test_id' => 4),
		array('id' => 8, 'title' => 'III', 'test_id' => 5),
		array('id' => 9, 'title' => 'NNN', 'test_id' => 7),
	);
}
?>