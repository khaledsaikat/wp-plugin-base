<?php

class TestCase extends WP_UnitTestCase
{

    /**
     * Get protected/private property of a class.
     *
     * @param object &$object
     * @param string $name Property name
     *
     * @return mixed Method return.
     */
    public function getProperty(&$object, $name)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $property = $reflection->getProperty($name);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}
