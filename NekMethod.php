<?php

namespace kabayaki\PHPNekonium;

class NekMethod
{
    private $name;
    private $param;

    /**
     * NekoniumMethod constructor.
     * @param $name string Method name
     * @param $param array Method parameters in asoc
     */
    public function __construct($name, $param)
    {
        $this->name = $name;
        $this->param = $param;
    }


    /**
     * Returns Nekonium API method name.
     * @return string Nekonium method's name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Returns method parameters being set when instance was created.
     * @return array Given parameters when instance was created
     */
    public function getParam() {
        return $this->param;
    }
}