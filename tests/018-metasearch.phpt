--TEST--
Metasearch test
--SKIPIF--
<?php
include dirname(__FILE__) . "/skipif.inc";

if (!method_exists('TokyoTyrantQuery', 'metaSearch'))
	die("skip No metasearch available");
?>
--FILE--
<?php
include dirname(__FILE__) . '/config.inc';

$tt = new TokyoTyrantTable(TT_TABLE_HOST, TT_TABLE_PORT);
$tt->vanish();

$tt->put('cherry',     array('color' => 'red'));
$tt->put('strawberry', array('color' => 'red'));
$tt->put('apple',      array('color' => 'green'));
$tt->put('lemon',      array('color' => 'yellow'));

$query = $tt->getQuery();
$query->addCond('color', TokyoTyrant::RDBQC_STREQ, 'red')->setOrder('color', TokyoTyrant::RDBQO_STRASC);

$query1 = $tt->getQuery();
$query1->addCond('color', TokyoTyrant::RDBQC_STREQ, 'yellow');

var_dump($query->metaSearch(array($query1), TokyoTyrant::RDBMS_UNION));

?>
--EXPECTF--
array(3) {
  ["%s"]=>
  array(1) {
    ["color"]=>
    string(3) "red"
  }
  ["%s"]=>
  array(1) {
    ["color"]=>
    string(3) "red"
  }
  ["%s"]=>
  array(1) {
    ["color"]=>
    string(6) "yellow"
  }
}