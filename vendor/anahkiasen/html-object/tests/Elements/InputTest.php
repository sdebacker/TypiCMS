<?php
use HtmlObject\Input;

class InputTest extends HtmlObjectTestCase
{
  public function testCanCreateBasicInput()
  {
    $input = new Input('text', 'foo', 'bar');
    $matcher = $this->getInputMatcher('text', 'foo', 'bar');

    $this->assertHTML($matcher, $input);
  }

  public function testCanDynamicallyCreateInputTypes()
  {
    $input1 = Input::create('text', 'foo', 'bar');
    $input2 = Input::text('foo', 'bar');
    $matcher = $this->getInputMatcher('text', 'foo', 'bar');

    $this->assertEquals($input1, $input2);
    $this->assertHTML($matcher, $input2);
  }

  public function testCanHaveZeroValue()
  {
    $input = Input::create('number', 'foo', 0)->render();
    $matcher = '<input type="number" name="foo" value="0">';

    $this->assertEquals($matcher, $input);
  }

  public function testCanHaveMinAndMax()
  {
    $input = Input::create('number', 'foo', 0)->min(50)->max(100)->render();
    $matcher = '<input type="number" name="foo" min="50" max="100" value="0">';

    $this->assertEquals($matcher, $input);
  }

  public function testMinCanBeZero()
  {
    $input = Input::create('number', 'foo', 0)->min(0)->max(100)->render();
    $matcher = '<input type="number" name="foo" min="0" max="100" value="0">';

    $this->assertEquals($matcher, $input);
  }

}