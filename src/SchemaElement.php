<?php

namespace Fiasco\MetaYaml;

class SchemaElement {

  protected $parent;
  protected $element;

  public function __construct(Array $element, ? SchemaElement $parent = NULL)
  {
    $this->element = $element;
    $this->parent = $parent;
  }

  public function getChildren()
  {
    $children = array_filter($this->element, function ($key) {
      return substr($key, 0, 1) != '_';
    }, ARRAY_FILTER_USE_KEY);

    foreach ($children as &$child) {
      $child = new static($child, $this);
    }

    return $children;
  }

  public function getChild($key)
  {
    return isset($this->element[$key]) ? new static($this->element[$key], $this) : FALSE;
  }

  public function getAttributes()
  {
    return array_filter($this->element, function ($key) {
      return substr($key, 0, 1) == '_';
    }, ARRAY_FILTER_USE_KEY);
  }

  public function getAttribute($key)
  {
    $key = '_' . $key;
    return $this->element[$key] ?? FALSE;
  }


}
