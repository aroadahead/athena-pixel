<?php

declare(strict_types=1);

namespace AthenaPixel\Model;

use Application\Model\ApplicationModel;
use Laminas\Db\ResultSet\ResultSetInterface;

class DesignPackageAsset extends ApplicationModel
{
    public static function getAllJs(int $designPackageId, bool $useModelInsteadOfEntity = false): ?ResultSetInterface
    {
        return static::getAllAssets($designPackageId,$useModelInsteadOfEntity,'js');
    }

    public static function getAllCss(int $designPackageId, bool $useModelInsteadOfEntity = false): ?ResultSetInterface
    {
        return static::getAllAssets($designPackageId,$useModelInsteadOfEntity,'css');
    }

    public static function getAllMeta(int $designPackageId, bool $useModelInsteadOfEntity=false):?ResultSetInterface
    {
        return static::getAllAssets($designPackageId,$useModelInsteadOfEntity,'meta');
    }

    public static function getAllFonts(int $designPackageId, bool $useModelInsteadOfEntity=false):?ResultSetInterface
    {
        return static::getAllAssets($designPackageId,$useModelInsteadOfEntity,'font');
    }

    protected static function getAllAssets(int $designPackageId, bool $useModelInsteadOfEntity, string $mode):?ResultSetInterface
    {
        $instance = new self($useModelInsteadOfEntity);
        $select = $instance->getCurrentSelect();
        $select -> order('sort ASC');
        $where = $select->where;
        $predicateSet = $where->nest();
        $predicateSet->and->equalTo('designpackageid',$designPackageId);
        $predicateSet->and->equalTo('status',1);
        $predicateSet->and->equalTo('mode',$mode);
        $predicateSet->unnest();
        $select->where($where);
        return $instance->fetchAll();
    }
}