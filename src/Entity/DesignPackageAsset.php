<?php

declare(strict_types=1);

/**
 * @package \Design\Entity
 */
namespace AthenaPixel\Entity;

/**
 * Import Statements
 */
use Application\Entity\AbstractEntity;

/**
 * Class DesignPackageAsset
 *
 * @package \Design\Entity
 * @extends AbstractEntity
 */
class DesignPackageAsset extends AbstractEntity
{
    /**
     * Return name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this -> get('name');
    }

    /**
     * Return mode.
     *
     * @return string
     */
    public function getMode(): string
    {
        return $this -> get('mode');
    }

    /**
     * Return type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this -> get('type');
    }

    /**
     * Return content.
     *
     * @return string|null
     */
    public function getContent(): string|null
    {
        return $this -> get('content');
    }

    /**
     * Return conditional.
     *
     * @return string|null
     */
    public function getConditional(): string|null
    {
        return $this -> get('conditional');
    }

    /**
     * Return method.
     *
     * @return string|null
     */
    public function getMethod(): string|null
    {
        return $this -> get('method');
    }

    /**
     * Return media.
     *
     * @return string|null
     */
    public function getMedia(): string|null
    {
        return $this -> get('media');
    }

    /**
     * Return file.
     *
     * @return string|null
     */
    public function getFile(): string|null
    {
        return $this -> get('file');
    }

    /**
     * Return extra.
     *
     * @return array|null
     */
    public function getExtra(): array|null
    {
        if (!is_null($this -> get('extra'))) {
            return unserialize($this -> get('extra'));
        }
        return null;
    }

    /**
     * Return package.
     *
     * @return string|null
     */
    public function getPackage(): string|null
    {
        return $this -> get('package');
    }

    /**
     * Return theme.
     *
     * @return string|null
     */
    public function getTheme(): string|null
    {
        return $this -> get('theme');
    }

    /**
     * Return skin.
     *
     * @return string|null
     */
    public function getSkin(): string|null
    {
        return $this -> get('skin');
    }

    /**
     * Return module.
     *
     * @return string|null
     */
    public function getModule(): string|null
    {
        return $this -> get('module');
    }

    /**
     * Return controller.
     *
     * @return string|null
     */
    public function getController(): string|null
    {
        return $this -> get('controller');
    }

    /**
     * Return action.
     *
     * @return string|null
     */
    public function getAction(): string|null
    {
        return $this -> get('action');
    }

    /**
     * Return sort.
     *
     * @return int
     */
    public function getSort(): int
    {
        return (int)$this -> get('sort');
    }

    /**
     * Return priority (sort)
     *
     * @return int
     */
    public function getPriority(): int
    {
        return $this -> getSort();
    }

    /**
     * Return skin args.
     *
     * @return array
     */
    public function getSkinsArgs(): array
    {
        return array(
            $this -> getPackage(),
            $this -> getTheme(),
            $this -> getSkin(),
            $this -> getModule(),
            $this -> getController(),
            $this -> getAction()
        );
    }

    /**
     * Is asset enabled?
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this -> getStatus() > 0;
    }

    /**
     * Is cross-origin anonymous?
     *
     * @return bool
     */
    public function isCrossOriginAnonymous(): bool
    {
        return true;
    }
}