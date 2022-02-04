<?php

declare(strict_types=1);

namespace AthenaPixel\Model;

use AthenaCore\Mvc\Application\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSetInterface;

class DesignPackageAsset extends TableGateway
{
    public static function getAllByJsDesignPackage(int $designPackageId, bool $useModelInsteadOfEntity = false): ?ResultSetInterface
    {
        return static::getAllByDesignPackage($designPackageId,$useModelInsteadOfEntity,'js');
    }

    public static function getAllByCssDesignPackage(int $designPackageId, bool $useModelInsteadOfEntity = false): ?ResultSetInterface
    {
        return static::getAllByDesignPackage($designPackageId,$useModelInsteadOfEntity,'css');
    }

    public static function getAllByMetaDesignPackage(int $designPackageId, bool $useModelInsteadOfEntity=false):?ResultSetInterface
    {
        return static::getAllByDesignPackage($designPackageId,$useModelInsteadOfEntity,'meta');
    }

    public static function getAllByFontsDesignPackage(int $designPackageId, bool $useModelInsteadOfEntity=false):?ResultSetInterface
    {
        return static::getAllByDesignPackage($designPackageId,$useModelInsteadOfEntity,'font');
    }

    protected static function getAllByDesignPackage(int $designPackageId, bool $useModelInsteadOfEntity,string $mode):?ResultSetInterface
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