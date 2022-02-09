<?php
declare(strict_types=1);

namespace AthenaPixel\Model;

use Application\Model\ApplicationModel;
use Laminas\Db\ResultSet\ResultSetInterface;

class Navigation extends ApplicationModel
{
    public static function byDesignPackageAndResourceOrDefault(int    $designPkgId, string $module, string $controller,
                                                               string $action, bool $useModelInsteadOfEntity = false): ?ResultSetInterface
    {
        $instance = new self($useModelInsteadOfEntity);
        $select = $instance -> getSql() -> select();
        $select -> where([
            'designpackageid' => $designPkgId,
            'module' => $module,
            'controller' => $controller,
            'action' => $action,
            'status' => 1
        ]);
        $select -> order('sort ASC');
        $data = $instance -> selectWith($select);
        if (!$data -> count()) {
            $select = $instance -> getSql() -> select();
            $select -> where([
                'designpackageid' => $designPkgId,
                'module' => 'default',
                'controller' => 'default',
                'action' => 'default',
                'status' => 1
            ]);
            $select -> order('sort ASC');
            $data = $instance -> selectWith($select);
        }
        return $data;
    }
}