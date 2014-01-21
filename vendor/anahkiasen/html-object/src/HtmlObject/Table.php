<?php
namespace HtmlObject;

/**
 * A table
 */
class Table extends Element
{
  /**
   * Default element
   *
   * @var string
   */
  protected $element = 'table';

  /**
   * Whether the element is self closing
   *
   * @var boolean
   */
  protected $isSelfClosing = false;

  /**
   * Default element for nested children
   *
   * @var string
   */
  protected $defaultChild = 'tr';

  ////////////////////////////////////////////////////////////////////
  //////////////////////////// CORE METHODS //////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Creates a basic Table
   *
   * @param array $headers
   * @param array $rows
   * @param array $attributes
   */
  public function __construct(array $headers = array(), array $rows = array(), $attributes = array())
  {
    // Build headers
    $this->headers($headers);
    $this->rows($rows);
  }

  /**
   * Static alias for constructor
   *
   * @param string          $element
   * @param string|null|Tag $value
   * @param array           $attributes
   * @return                Table
   */
  public static function create($headers = array(), $rows = array(), $attributes = array())
  {
    return new static($headers, $rows, $attributes);
  }

  ////////////////////////////////////////////////////////////////////
  /////////////////////////////// CHILDREN ///////////////////////////
  ////////////////////////////////////////////////////////////////////

  /**
   * Set the table's headers
   *
   * @param array $headers
   *
   * @return self
   */
  public function headers(array $headers = array())
  {
    // Cancel if no headers
    if (!$headers) {
      return $this;
    }

    // Create thead
    $thead = Element::create('tr');
    foreach ($headers as $header) {
      $thead->nest('th', $header);
    }

    // Nest into table
    $this->nest(array(
      'thead' => Element::create('thead')->nest(array(
        'tr' => $thead,
      )),
    ));

    return $this;
  }

  /**
   * Set the table's rows
   *
   * @param array $rows
   *
   * @return self
   */
  public function rows(array $rows = array())
  {
    // Cancel if no rows
    if (!$rows) {
      return $this;
    }

    // Create tbody
    $tbody = Element::create('tbody');
    foreach ($rows as $row) {
      $tr = Element::create('tr');
      foreach ($row as $column => $value) {
        $td = Element::create('td', $value);
        $tr->setChild($td);
      }
      $tbody->setChild($tr);
    }

    // Nest into table
    $this->nest(array(
      'tbody' => $tbody,
    ));

    return $this;
  }
}
