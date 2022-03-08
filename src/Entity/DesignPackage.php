<?php
declare(strict_types=1);
namespace AthenaPixel\Entity;

use Application\Entity\ApplicationEntity;

class DesignPackage extends ApplicationEntity
{
    /**
     * Return package.
     *
     * @return string
     */
    public function getPackage(): string
    {
        return $this -> get('package');
    }

    /**
     * Return theme.
     *
     * @return string
     */
    public function getTheme(): string
    {
        return $this -> get('theme');
    }

    /**
     * Return skin.
     *
     * @return string
     */
    public function getSkin(): string
    {
        return $this -> get('skin');
    }

    /**
     * Return group.
     *
     * @return string
     */
    public function getGroup(): string
    {
        return $this -> get('group');
    }

    /**
     * Return module.
     *
     * @return string
     */
    public function getModule(): string
    {
        return 'application';
    }

    /**
     * Return controller.
     *
     * @return string
     */
    public function getController(): string
    {
        return 'index';
    }

    /**
     * Return action.
     *
     * @return string
     */
    public function getAction(): string
    {
        return 'index';
    }
}