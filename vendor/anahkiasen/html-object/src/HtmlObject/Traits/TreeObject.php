<?php
namespace HtmlObject\Traits;

use Closure;
use HtmlObject\Element;
use HtmlObject\Text;

/**
 * An abstract class to create and manage trees of objects
 */
abstract class TreeObject
{
  /**
   * Parent of the object
   *
   * @var TreeObject
   */
  protected $parent;

  /**
   * The name of the child for the parent
   *
   * @var string
   */
  public $parentIndex;

  /**
   * Children of the object
   *
   * @var array
   */
  protected $children = array();

  // Defaults
  ////////////////////////////////////////////////////////////////////

  /**
   * Default element for nested children
   *
   * @var string
   */
  protected $defaultChild;

  ////////////////////////////////////////////////////////////////////
  /////////////////////////////// PARENT /////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Get the Element's parent
   *
   * @param integer $levels The number of levels to go back up
   *
   * @return Element
   */
  public function getParent($levels = null)
  {
    if (!$levels) return $this->parent;

    $subject = $this;
    for ($i = 0; $i <= $levels; $i++) {
      $subject = $subject->getParent();
    }

    return $subject;
  }

  /**
   * Set the parent of the element
   *
   * @param TreeObject $parent
   *
   * @return TreeObject
   */
  public function setParent(TreeObject $parent)
  {
    $this->parent = $parent;

    return $this;
  }

  /**
   * Check if an object has a parent
   *
   * @return boolean
   */
  public function hasParent()
  {
    return (bool) $this->parent;
  }

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// CHILDREN ////////////////////////////
  ////////////////////////////////////////////////////////////////////

  // Get
  ////////////////////////////////////////////////////////////////////

  /**
   * Get a specific child of the element
   *
   * @param string $name The Element's name
   *
   * @return Element
   */
  public function getChild($name)
  {
    // Direct fetching
    $child = Helpers::arrayGet($this->getChildren(), $name);
    if ($child) {
      return $child;
    }

    // Dot notation
    $children = explode('.', $name);
    if (sizeof($children) == 1) {
      return Helpers::arrayGet($this->getChildren(), $children[0]);
    }

    // Recursive fetching
    $subject = $this;
    foreach ($children as $child) {
      if (!$subject) {
        return;
      }

      $subject = $subject->getChild($child);
    }

    return $subject;
  }

  /**
   * Check if an Element has a Child
   *
   * @param string $name The child's name
   *
   * @return boolean
   */
  public function hasChild($name)
  {
    return (bool) $this->getChild($name);
  }

  /**
   * Get all children
   *
   * @return array
   */
  public function getChildren()
  {
    return $this->children;
  }

  /**
   * Check if the object has children
   *
   * @return boolean
   */
  public function hasChildren()
  {
    return !is_null($this->children) and !empty($this->children);
  }

  /**
   * Check if a given element is after another sibling
   *
   * @param integer|string $sibling The sibling
   *
   * @return boolean
   */
  public function isAfter($sibling)
  {
    $children = array_keys($this->getParent()->getChildren());
    $child    = array_search($this->parentIndex, $children);
    $sibling  = array_search($sibling, $children);

    return $child > $sibling;
  }

  // Set
  ////////////////////////////////////////////////////////////////////

  /**
   * Nests an object withing the current object
   *
   * @param Tag|string $element    An element name or an Tag
   * @param string     $value      The Tag's alias or the element's content
   * @param array      $attributes
   *
   * @return Tag
   */
  public function nest($element, $value = null, $attributes = array())
  {
    // Alias for nestChildren
    if (is_array($element)) {
      return $this->nestChildren($element);
    }

    // Transform the element
    if (!($element instanceof TreeObject)) {
      $element = $this->createTagFromString($element, $value, $attributes);
    }

    // If we seek to nest into a child, get the child and nest
    if ($this->hasChild($value)) {
      $element = $this->getChild($value)->nest($element);
    }

    return $this->setChild($element, $value);
  }

  /**
   * Nest an array of objects/values
   *
   * @param array $children
   */
  public function nestChildren($children)
  {
    if (!is_array($children)) {
      return $this;
    }

    foreach ($children as $element => $value) {
      if (is_numeric($element)) {
        if($value instanceof TreeObject) $this->setChild($value);
        elseif($this->defaultChild) $this->nest($this->defaultChild, $value);
      } else {
        if($value instanceof TreeObject) $this->setChild($value, $element);
        else $this->nest($element, $value);
      }
    }

    return $this;
  }

  /**
   * Add an object to the current object
   *
   * @param string|TreeObject  $child The child
   * @param string             $name  Its name
   * @param boolean            $flat
   *
   * @return TreeObject
   */
  public function setChild($child, $name = null, $flat = false)
  {
    if (!$name) {
      $name = sizeof($this->children);
    }

    // Get subject of the setChild
    if (!$flat) {
      $subject = explode('.', $name);
      $name    = array_pop($subject);
      $subject = implode('.', $subject);
      $subject = $subject ? $this->getChild($subject) : $this;
    } else {
      $subject = $this;
    }

    return $this->insertChildAtPosition($child, $name, $subject);
  }

  // Prepend or append
  ////////////////////////////////////////////////////////////////////

  /**
   * Append to an element
   *
   * @param Element $child
   * @param string  $name
   * @param string  $to
   *
   * @return self
   */
  public function appendChild($child, $name = null, $to = null)
  {
    return $this->insertChildAtPosition($child, $name, null, $to);
  }

  /**
   * Prepend to an element
   *
   * @param Element $child
   * @param string  $name
   * @param string  $to
   *
   * @return self
   */
  public function prependChild($child, $name = null, $to = 0)
  {
    return $this->insertChildAtPosition($child, $name, null, $to, true);
  }

  /**
   * Prepend or append to self/child
   *
   * @param Closure  $onSubject
   * @param Element  $child
   * @param string   $name
   * @param string   $to
   * @param boolean  $before
   *
   * @return self
   */
  protected function insertChildAtPosition($child, $name = null, $subject = null, $position = null, $before = false)
  {
    // Get default child name
    $subject = $subject ?: $this;
    $name    = $name ?: sizeof($this->children);

    // Bind parent to child
    if ($child instanceof TreeObject) {
      $child->setParent($subject);
    }

    // Add object to children
    $child->parentIndex = $name;

    // If the position is a child name, get its index
    $before   = $before ? 0 : 1;
    $position = is_null($position) ? sizeof($subject->children) : $position;
    if (is_string($position)) {
      $position = array_search($position, array_keys($subject->children));
    }

    // Slice and recompose children
    $subject->children =
      array_slice($subject->children, 0, $position + $before, true) +
      array($name => $child) +
      array_slice($subject->children, $position, sizeof($subject->children), true);

    return $this;
  }

  ////////////////////////////////////////////////////////////////////
  ////////////////////////////// HELPERS /////////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Creates an Element or a TextNode from an element/value combo
   *
   * @param string $element    The element/string
   * @param string $value      The element's content
   * @param array  $attributes
   *
   * @return TreeObject
   */
  protected function createTagFromString($element, $value = null, $attributes = array())
  {
    // If it's an element/value, create the element
    if (strpos($element, '<') === false and !$this->hasChild($value) and Helpers::isKnownTag($element)) {
      return new Element($element, $value, $attributes);
    }

    // Else create a text element
    if ($this->hasChild($value) or !$value) {
      return new Text($element);
    }

    return new Text($value);
  }
}
