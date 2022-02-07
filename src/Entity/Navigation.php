<?php

namespace AthenaPixel\Entity;

class Navigation extends \Application\Entity\AbstractEntity
{
    public function getDesignpackageid(): int
    {
        return $this -> get('designpackageid');
    }

    public function getModule(): string
    {
        return $this -> get('module');
    }

    public function getController(): string
    {
        return $this -> get('controller');
    }

    public function getAction(): string
    {
        return $this -> get('action');
    }

    public function getLabel(): string
    {
        return $this -> get('label');
    }

    public function getRoute(): string
    {
        return $this -> get('route');
    }

    public function getTitle(): string
    {
        return $this -> get('title');
    }

    public function getResource(): string
    {
        return $this -> get('resource');
    }
}