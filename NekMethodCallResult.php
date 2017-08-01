<?php

namespace kabayaki\PHPNekonium;

abstract class NekMethodCallResult
{
    private $id;
    private $result;

    /**
     * NekMethodCallResult constructor.
     *
     * @param $id int Id for the method call
     * @param $result array Result of the method call as assoc array
     */
    public function __construct($id, $result)
    {
        $this->id = $id;
        $this->result = $result;
    }

    /**
     * Get id for the method call.
     *
     * @return int Id for the method call
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get result of the method call as assoc array.
     *
     * @return array Result of the method call as assoc array
     */
    public function getResultArray(): array
    {
        return $this->result;
    }
}