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
    foreach ($this->getAttribute('children') as $child) {
      yield new static($child, $this);
    }
  }

  public function getChild($key)
  {
    if (!isset($this->element['_children'][$key])) {
      $children = array_keys($this->getChildren());
      throw new \Exception("Could not find child '$key' in (" . implode(', ', $children) . ")");
    }
    return new static($this->element['_children'][$key], $this);
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
