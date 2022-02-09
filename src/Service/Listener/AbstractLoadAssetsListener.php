<?php
declare(strict_types=1);
namespace AthenaPixel\Service\Listener;

use AthenaCore\Mvc\Service\Listener\AbstractServiceListener;
use Laminas\View\Renderer\RendererInterface;

abstract class AbstractLoadAssetsListener extends AbstractServiceListener
{
    /**
     * Type Api
     *
     * @var string
     */
    public const TYPE_API = 'api';

    /**
     * Type Vendor
     *
     * @var string
     */
    public const TYPE_VENDOR = 'vendor';

    /**
     * Type JS
     *
     * @var string
     */
    public const TYPE_JS = "js";

    /**
     * Type Css
     *
     * @var string
     */
    public const TYPE_CSS = "css";

    /**
     * Type Skin
     *
     * @var string
     */
    public const TYPE_SKIN = "skin";

    /**
     * Type Font
     *
     * @var string
     */
    public const TYPE_FONT = "font";

    /**
     * Type Text/Javascript
     *
     * @var string
     */
    public const TYPE_TEXT_JAVASCRIPT = 'text/javascript';

    /**
     * Type Screen/Projection
     *
     * @var string
     */
    public const TYPE_SCREEN_PROJECTION = 'screen,projection';

    /**
     * Crossorigin Anonymous
     *
     * @var array
     */
    public const CROSSORIGIN_ANONYMOUS = ['crossorigin' => 'anonymous'];

    protected static ?int $dpId = null;
    protected static ?RendererInterface $renderer=null;

    protected function getDesignPackageId(): int
    {
        if (self ::$dpId === null) {
            self ::$dpId = $this -> container -> get('design') -> getDesignPackageId();
        }
        return self ::$dpId;
    }

    protected function getRenderer(): RendererInterface
    {
        if (self ::$renderer === null) {
            self ::$renderer = $this -> container -> get('ViewHelperManager') -> getRenderer();
        }
        return self ::$renderer;
    }

    public function getFilePath(string $type, string $file, string $assetType, array $skinsArgs = []): string
    {
        if ($type == self::TYPE_API) {
            return $file;
        }
        if ($type == self::TYPE_VENDOR) {
            return $this -> getRenderer() -> vendorPath($file);
        }
        if ($type == self::TYPE_SKIN) {
            return match ($assetType) {
                self::TYPE_JS => $this -> getRenderer() -> skinsJsPath($skinsArgs, $file),
                self::TYPE_CSS => $this -> getRenderer() -> skinsCssPath($skinsArgs, $file),
                self::TYPE_FONT => $this -> getRenderer() -> skinsFontsPath($skinsArgs, $file)
            };
        }
        return match ($assetType) {
            self::TYPE_JS => $this -> getRenderer() -> jsPath($file),
            self::TYPE_CSS => $this -> getRenderer() -> cssPath($file),
            self::TYPE_FONT => $this -> getRenderer() -> fontsPath($file)
        };
    }

    protected function prependJsFile(string $filePath, array $extra): void
    {
        $this -> getRenderer()
            -> headScript()
            -> prependFile($filePath, self::TYPE_TEXT_JAVASCRIPT, $extra);
    }

    protected function appendJsFile(string $filePath, array $extra): void
    {
        $this -> getRenderer()
            -> headScript()
            -> appendFile($filePath, self::TYPE_TEXT_JAVASCRIPT, $extra);
    }

    protected function appendStylesheet(string $filePath, string $media, string $conditional, array $extra): void
    {
        $this -> getRenderer()
            -> headLink()
            -> appendStylesheet($filePath, $media, $conditional, $extra);
    }

    protected function prependStylesheet(string $filePath, string $media, string $conditional, array $extra): void
    {
        $this -> getRenderer()
            -> headLink()
            -> prependStylesheet($filePath, $media, $conditional, $extra);
    }
}