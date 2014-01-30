<?php
namespace HtmlObject\Traits;

/**
 * Static helpers used troughout the classes
 */
class Helpers
{
  /**
   * Check if a string is an existing HTML tag
   *
   * @param string $tag
   *
   * @return boolean
   */
  public static function isKnownTag($tag)
  {
    return in_array($tag, array(
      'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'article', 'aside',
      'audio', 'b', 'base', 'basefont', 'bdi', 'bdo', 'big', 'blockquote',
      'body', 'br', 'button', 'canvas', 'caption', 'center', 'cite', 'code',
      'col', 'colgroup', 'command', 'datalist', 'dd', 'del', 'details', 'dfn',
      'dialog', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'figcaption',
      'figure', 'font', 'footer', 'form', 'frame', 'frameset', 'h1', 'head',
      'header', 'hr', 'html', 'i', 'iframe', 'img', 'input', 'ins', 'kbd',
      'keygen', 'label', 'legend', 'li', 'link', 'map', 'mark', 'menu', 'meta',
      'meter', 'nav', 'noframes', 'noscript', 'object', 'ol', 'optgroup', 'option',
      'output', 'p', 'param', 'pre', 'progress', 'q', 'rp', 'rt', 'ruby', 's',
      'samp', 'script', 'section', 'select', 'small', 'source', 'span',
      'strike', 'strong', 'style', 'sub', 'summary', 'sup', 'table', 'tbody',
      'td', 'textarea', 'tfoot', 'th', 'thead', 'time', 'title', 'tr', 'track',
      'tt', 'u', 'ul', 'var', 'video', 'wbr'
    ));
  }

  /**
   * Converts a string to hyphenated-casing
   *
   * @param  string $string
   *
   * @return string
   */
  public static function hyphenated($string)
  {
    return ctype_lower($string) ? $string : strtolower(preg_replace('/(.)([A-Z])/', '$1-$2', $string));
  }

  /**
   * Get a value from an array
   *
   * @param array  $array
   * @param string $key
   * @param string $fallback
   *
   * @return mixed
   */
  public static function arrayGet($array, $key, $fallback = null)
  {
    return isset($array[$key]) ? $array[$key] : $fallback;
  }

  /**
   * Build a list of HTML attributes from an array
   *
   * @param  array  $attributes
   * @return string
   */
  public static function parseAttributes($attributes)
  {
    $html = array();

    foreach ((array) $attributes as $key => $value) {

      // Valueless attributes
      if (is_numeric($key)) {
        $key = $value;
      }

      // Ignore some attributes
      if (!$value and !in_array($key, array('value', 'min', 'max'))) {
        continue;
      }

      // Check for JSON attributes
      if (in_array(substr($value, 0, 1), array('{', '['))) {
        $html[] = $key."='".$value."'";
        continue;
      }

      $html[] = $key. '="' .$value. '"';
    }

    return (count($html) > 0) ? ' '.implode(' ', $html) : '';
  }
}
