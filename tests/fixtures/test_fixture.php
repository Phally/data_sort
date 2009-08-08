<?php
class TestFixture extends CakeTestFixture {
	public $table = 'tests';
	
	public $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 2),
		'associated_test_count' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	
	public $records = array(
		array('id' => 1, 'name' => 'AB', 'associated_test_count' => 2,'created' => '2009-08-22 21:39:15'),
		array('id' => 2, 'name' => 'CD', 'associated_test_count' => 1, 'created' => '2009-08-22 21:39:14'),
		array('id' => 3, 'name' => 'EF', 'associated_test_count' => 2, 'created' => '2009-08-22 21:39:16'),
		array('id' => 4, 'name' => 'GH', 'associated_test_count' => 2, 'created' => '2009-08-22 21:39:18'),
		array('id' => 5, 'name' => 'IJ', 'associated_test_count' => 1, 'created' => '2009-08-22 21:39:19'),
		array('id' => 6, 'name' => 'KL', 'associated_test_count' => 0, 'created' => '2009-08-22 21:39:10'),
		array('id' => 7, 'name' => 'MN', 'associated_test_count' => 1, 'created' => '2009-08-22 21:39:09'),
	);
}
?>