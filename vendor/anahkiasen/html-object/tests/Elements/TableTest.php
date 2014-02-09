<?php
use HtmlObject\Table;

class TableTest extends HtmlObjectTestCase
{
  public function testCanCreateBasicTable()
  {
    $table = Table::create();

    $this->assertEquals('<table></table>', $table->render());
  }

  public function testCanCreateHeaders()
  {
    $table = Table::create(array(
      'Name', 'Email'
    ));

    $this->assertEquals('<table><thead><tr><th>Name</th><th>Email</th></tr></thead></table>', $table->render());
  }

  public function testCanCreateRows()
  {
    $table = Table::create(array('Name', 'Email'), array(
      array('Maxime Fabre', 'foo@bar.com'),
      array('Peter', 'peter@griffin.com'),
    ))->addClass('foobar');

    $this->assertEquals(
      '<table class="foobar">'.
        '<thead>'.
          '<tr>'.
            '<th>Name</th>'.
            '<th>Email</th>'.
          '</tr>'.
        '</thead>'.
        '<tbody>'.
          '<tr>'.
            '<td>Maxime Fabre</td>'.
            '<td>foo@bar.com</td>'.
          '</tr>'.
          '<tr>'.
            '<td>Peter</td>'.
            '<td>peter@griffin.com</td>'.
          '</tr>'.
        '</tbody>'.
      '</table>', $table->render());
  }
}