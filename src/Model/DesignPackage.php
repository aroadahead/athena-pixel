<?php
declare(strict_types=1);

namespace AthenaPixel\Model;

use Application\Model\ApplicationModel;

class DesignPackage extends ApplicationModel
{
    /**
     * Set name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this -> dataSet -> set('name', $name);
    }

    /**
     * Set package
     *
     * @param string $package
     * @return void
     */
    public function setPackage(string $package): void
    {
        $this -> dataSet -> set('package', $package);
    }

    /**
     * Set theme
     *
     * @param string $theme
     * @return void
     */
    public function setTheme(string $theme): void
    {
        $this -> dataSet -> set('theme', $theme);
    }

    /**
     * Set skin
     *
     * @param string $skin
     * @return void
     */
    public function setSkin(string $skin): void
    {
        $this -> dataSet -> set('skin', $skin);
    }

    /**
     * Set group
     *
     * @param string $group
     * @return void
     */
    public function setGroup(string $group): void
    {
        $this -> dataSet -> set('group', $group);
    }
}