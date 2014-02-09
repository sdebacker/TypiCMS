<?php
use HtmlObject\Element;
use HtmlObject\Input;

class TreeObjectTest extends HtmlObjectTestCase
{
  public function setUp()
  {
    parent::setUp();

    $this->object = new Element('p', 'foo');
  }

  public function testCanNest()
  {
    $object = Element::strong('foo');
    $this->object->nest('strong', 'foo');

    $this->assertEquals('<p>foo<strong>foo</strong></p>', $this->object->render());
  }

  public function testCanNestStrings()
  {
    $object = Element::strong('foo');
    $this->object->nest('<strong>foo</strong>');

    $this->assertEquals('<p>foo<strong>foo</strong></p>', $this->object->render());
  }

  public function testCanNestObjects()
  {
    $object = Element::strong('foo');
    $this->object->nest($object);

    $this->assertEquals('<p>foo<strong>foo</strong></p>', $this->object->render());
  }

  public function testCanNestObjectsInChildren()
  {
    $object = Element::strong('foo');
    $link   = Element::a('foo');
    $this->object->nest($object, 'body');
    $this->object->nest($link, 'body.link');

    $this->assertEquals('<p>foo<strong>foo<a>foo</a></strong></p>', $this->object->render());
  }

  public function testCanNestStringsInChildren()
  {
    $strong = Element::strong('title');
    $title  = Element::h1('bar')->nest($strong, 'strong');
    $object = Element::div()->nest($title, 'title');
    $this->object->nest($object, 'body');
    $this->object->nest('by <a>someone</a>', 'body.title');

    $this->assertEquals('<p>foo<div><h1>bar<strong>title</strong>by <a>someone</a></h1></div></p>', $this->object->render());
  }

  public function testCanGetNestedElements()
  {
    $object = Element::strong('foo');
    $this->object->nest($object, 'foo');

    $this->assertEquals($object, $this->object->getChild('foo'));
  }

  public function testCanGetChildWithDotsInName()
  {
    $object = Element::p('foo');
    $this->object->setChild($object, '11:30 a.m.', true);

    $this->assertEquals($object, $this->object->getChild('11:30 a.m.'));
  }

  public function testCanAppendElementToAll()
  {
    $object = Element::create('p', 'foo')->nest(array(
      'foo' => Element::strong('foo'),
      'baz' => Element::strong('foo'),
    ));
    $object->appendChild(Element::strong('foo'), 'append');

    $this->assertEquals(array('foo', 'baz', 'append'), array_keys($object->getChildren()));
  }

  public function testCanPrependElementToAll()
  {
    $object = Element::create('p', 'foo')->nest(array(
      'foo' => Element::strong('foo'),
      'baz' => Element::strong('foo'),
    ));
    $object->prependChild(Element::strong('foo'), 'prepend');

    $this->assertEquals(array('prepend', 'foo', 'baz'), array_keys($object->getChildren()));
  }

  public function testCanPrependToChild()
  {
    $object = Element::create('p', 'foo')->nest(array(
      'foo' => Element::strong('foo'),
      'baz' => Element::strong('foo'),
    ));
    $object->prependChild(Element::strong('foo'), 'prepend', 'baz');

    $this->assertEquals(array('foo', 'prepend', 'baz'), array_keys($object->getChildren()));
  }

  public function testCanAppendToChild()
  {
    $object = Element::create('p', 'foo')->nest(array(
      'foo' => Element::strong('foo'),
      'baz' => Element::strong('foo'),
    ));
    $object->appendChild(Element::strong('foo'), 'append', 'foo');

    $this->assertEquals(array('foo', 'append', 'baz'), array_keys($object->getChildren()));
  }

  public function testCanNestMultipleValues()
  {
    $object = Element::strong('foo');
    $this->object->nestChildren(array('strong' => 'foo', 'em' => 'bar'));

    $this->assertEquals('<p>foo<strong>foo</strong><em>bar</em></p>', $this->object->render());
  }

  public function testWontNestIfTagDoesntExist()
  {
    $object = Element::strong('foo');
    $this->object->nest(array('strong' => 'foo', 'foobar' => 'bar'));

    $this->assertEquals('<p>foo<strong>foo</strong>bar</p>', $this->object->render());
  }

  public function testCanNestMultipleValuesUsingNest()
  {
    $object = Element::strong('foo');
    $this->object->nest(array('strong' => 'foo', 'em' => 'bar'));

    $this->assertEquals('<p>foo<strong>foo</strong><em>bar</em></p>', $this->object->render());
  }

  public function testCanNestMultipleElements()
  {
    $foo = Element::strong('foo');
    $bar = Element::p('bar');
    $this->object->nestChildren(array(
      'foo' => $foo,
      'bar' => $bar,
    ));

    $this->assertEquals($foo, $this->object->getChild('foo'));
    $this->assertEquals($bar, $this->object->getChild('bar'));
  }

  public function testCanNestMultipleObjects()
  {
    $strong = Element::strong('foo');
    $em = Element::em('bar');
    $this->object->nestChildren(array($strong, $em));

    $this->assertEquals('<p>foo<strong>foo</strong><em>bar</em></p>', $this->object->render());
  }

  public function testCanWalkTree()
  {
    $strong = Element::strong('foo');
    $this->object->nest($strong);

    $this->assertEquals($this->object, $this->object->getChild(0)->getParent());
  }

  public function testCanModifyChildren()
  {
    $strong = Element::strong('foo');
    $this->object->nest($strong);
    $this->object->getChild(0)->addClass('foo');

    $this->assertEquals('<p>foo<strong class="foo">foo</strong></p>', $this->object->render());
  }

  public function testCanCrawlToTextNode()
  {
    $this->object->nest('<strong>foo</strong>');
    $this->object->getChild(0)->addClass('foo');

    $this->assertEquals('<p>foo<strong>foo</strong></p>', $this->object->render());
  }

  public function testCanCrawlSeveralLayersDeep()
  {
    $strong = Element::strong('foo');
    $em     = Element::em('bar');
    $this->object->nest($strong, 'strong')->getChild('strong')->nest($em, 'em');

    $this->assertEquals('<p>foo<strong>foo<em>bar</em></strong></p>', $this->object->render());
    $this->assertEquals($em, $this->object->getChild('strong.em'));
  }

  public function testCanCrawlAnonymousLayers()
  {
    $strong = Element::strong('foo');
    $em     = Element::em('bar');
    $this->object->nest($strong)->getChild(0)->nest($em);

    $this->assertEquals('<p>foo<strong>foo<em>bar</em></strong></p>', $this->object->render());
    $this->assertEquals($em, $this->object->getChild('0.0'));
  }

  public function testCanGoBackUpSeveralLevels()
  {
    $strong = Element::strong('foo');
    $em     = Element::em('bar');
    $this->object->nest($strong, 'strong')->getChild('strong')->nest($em, 'em');
    $child = $this->object->getChild('strong.em');

    $this->assertEquals($child->getParent()->getParent(), $this->object);
    $this->assertEquals($child->getParent()->getParent(), $child->getParent(1));
  }

  public function testCanCheckIfObjectHasParent()
  {
    $this->object->setParent(Element::div());

    $this->assertTrue($this->object->hasParent());
  }

  public function testCanCheckIfObjectHasChildren()
  {
    $this->assertFalse($this->object->hasChildren());

    $this->object->nest(Element::div());
    $this->assertTrue($this->object->hasChildren());
  }

  public function testCanHaveSelfClosingChildren()
  {
    $tag = Element::div('foo')->nest(array(
      'foo' => Input::create('text'),
    ));

    $this->assertEquals('<div>foo<input type="text"></div>', $tag->render());
  }

  public function testCanCheckIfChildrenIsAfterSibling()
  {
    $this->object->nestChildren(array(
      'first' => Element::div(),
      'last' => Element::div(),
    ));
    $first = $this->object->first;
    $last  = $this->object->last;

    $this->assertTrue($last->isAfter('first'));
    $this->assertFalse($first->isAfter('last'));
  }

  public function testCanCheckIfElementHasChild()
  {
    $element = Element::create('div', 'foo');
    $this->object->nest($element, 'body');

    $this->assertTrue($this->object->hasChild('body'));
    $this->assertFalse($this->object->hasChild('title'));
  }
}