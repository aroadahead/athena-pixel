<?php

namespace AthenaPixel\Entity;

use JetBrains\PhpStorm\Pure;

class DesignPackageTemplate extends \Application\Entity\ApplicationEntity
{
    /**
     * Return controller identifier string
     *
     * @return string
     */
    #[Pure] public function getControllerIdentifierString(): string
    {
        return implode('/', array(
            $this -> get('module'),
            $this -> get('controller')
        ));
    }

    /**
     * Return module identifier string.
     *
     * @return string
     */
    #[Pure] public function getModuleIdentifierString(): string
    {
        return $this -> get('module');
    }

    /**
     * Return identifier string.
     *
     * @return string
     */
    #[Pure] public function getIdentifierString(): string
    {
        return implode('/', array(
            $this -> get('module'),
            $this -> get('controller'),
            $this -> get('action')
        ));
    }

    /**
     * Set identifier string.
     *
     * @param string $identifierString
     * @return void
     */
    public function setIdentifierString(string $identifierString): void
    {
        $this -> set('identifier_string', $identifierString);
    }

    /**
     * Set module.
     *
     * @param string $module
     * @return void
     */
    public function setModule(string $module): void
    {
        $this -> set('module', $module);
    }

    /**
     * Set controller.
     *
     * @param string $controller
     * @return void
     */
    public function setController(string $controller): void
    {
        $this -> set('controller', $controller);
    }

    /**
     * Set action.
     *
     * @param string $action
     */
    public function setAction(string $action)
    {
        $this -> set('action', $action);
    }
}