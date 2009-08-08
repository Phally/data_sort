<?php
class TestFixture extends CakeTestFixture {
	public $table = 'tests';
	
	public $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 2),
		'dummy_count' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	
	public $records = array(
		array('id' => 1, 'name' => 'AB', 'dummy_count' => 7,'created' => '2009-08-22 21:39:15'),
		array('id' => 2, 'name' => 'CD', 'dummy_count' => 6, 'created' => '2009-08-22 21:39:14'),
		array('id' => 3, 'name' => 'EF', 'dummy_count' => 5, 'created' => '2009-08-22 21:39:16'),
		array('id' => 4, 'name' => 'GH', 'dummy_count' => 4, 'created' => '2009-08-22 21:39:18'),
		array('id' => 5, 'name' => 'IJ', 'dummy_count' => 3, 'created' => '2009-08-22 21:39:19'),
		array('id' => 6, 'name' => 'KL', 'dummy_count' => 2, 'created' => '2009-08-22 21:39:10'),
		array('id' => 7, 'name' => 'MN', 'dummy_count' => 1, 'created' => '2009-08-22 21:39:09'),
	);
}
?>