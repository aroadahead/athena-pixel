<?php

namespace AthenaPixel\Model;

class DesignPackageTemplate extends \Application\Model\ApplicationModel
{
    public function allByDesignPackage(int $id):mixed
    {
        $inst = new self();
        $select = $inst->getCurrentSelect();
        $where = $select->where;
        $ps = $where->nest();
        $ps->and->equalTo('design_package_id',$id);
        $ps->and->equalTo('status',1);
        $ps->unnest();
        $select->where($where);
        return $inst->fetchAll();
    }
}