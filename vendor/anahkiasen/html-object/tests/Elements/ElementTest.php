<?php
use HtmlObject\Element;

class ElementTest extends HtmlObjectTestCase
{
  public function testCanDynamicallyCreateObjects()
  {
    $object = Element::p('foo')->class('bar');
    $matcher = $this->getMatcher();
    $matcher['attributes']['class'] = 'bar';

    $this->assertHTML($matcher, $object);
  }
}