<?php

namespace AthenaPixel\Model;

use Laminas\Db\ResultSet\ResultSetInterface;

class DesignPackageAsset extends \AthenaCore\Mvc\Application\Db\TableGateway\TableGateway
{
    public static function getAllByJsDesignPackage(int $designPackageId, bool $useModelInsteadOfEntity = false): ?ResultSetInterface
    {
        $instance = new self($useModelInsteadOfEntity);
        $select = $instance->getCurrentSelect();
        $select -> order('sort ASC');
        $where = $select->where;
        $predicateSet = $where->nest();
        $predicateSet->and->equalTo('designpackageid',$designPackageId);
        $predicateSet->and->equalTo('status',1);
        $predicateSet->and->equalTo('mode','js');
        $predicateSet->unnest();
        $select->where($where);
        return $instance->fetchAll();
    }
}