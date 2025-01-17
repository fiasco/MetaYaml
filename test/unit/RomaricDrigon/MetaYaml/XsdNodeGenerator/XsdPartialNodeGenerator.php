<?php

namespace test\unit\RomaricDrigon\MetaYaml\XsdNodeGenerator;

use mageekguy\atoum;
use RomaricDrigon\MetaYaml\XsdNodeGenerator\XsdPartialNodeGenerator as testedClass;
use RomaricDrigon\MetaYaml\XsdGenerator;

class XsdPartialNodeGenerator extends atoum\test
{
    public function testBase()
    {
        $this
            ->if($xsd_generator = new XsdGenerator())
            ->and($object = new testedClass($xsd_generator))
            ->then
                ->object($object)
                    ->isInstanceOf('RomaricDrigon\\MetaYaml\\XsdNodeGenerator\\XsdPartialNodeGenerator')
                    ->exception(function() use ($object) {
                      $writer = new \XMLWriter();
                      $schema = array('_partial' => 'nom_partial');
                      $object->build('test', $schema, $writer , false);
                    })
                    ->hasMessage("You're using a partial but partial 'nom_partial' is not defined in your schema")
        ;
    }
}
