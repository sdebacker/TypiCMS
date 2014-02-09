<?php
use HtmlObject\Traits\Helpers;

class HelpersTest extends HtmlObjectTestCase
{
	public function testCanParseAttributes()
	{
		$attributes = array('foo' => 'bar', 'baz' => 'qux');
		$attributes = Helpers::parseAttributes($attributes);

		$this->assertEquals(' foo="bar" baz="qux"', $attributes);
	}

	public function testCanParseValuelessAttributes()
	{
		$attributes = array('required', 'autofocus');
		$attributes = Helpers::parseAttributes($attributes);

		$this->assertEquals(' required="required" autofocus="autofocus"', $attributes);
	}

	public function testCanIgnoreNullAttributesWhenNecessary()
	{
		$attributes = array('min' => 0, 'max' => 0, 'value' => 0, 'required' => 0);
		$attributes = Helpers::parseAttributes($attributes);

		$this->assertEquals(' min="0" max="0" value="0"', $attributes);
	}
}