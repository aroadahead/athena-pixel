<?php

namespace AthenaPixel\Service\Listener;

use Laminas\Db\ResultSet\ResultSetInterface;

trait QueueAssetsTrait
{
    public function queue(ResultSetInterface $resultSet):array{
        $queue = new \SplPriorityQueue();

        /* @var $asset \AthenaPixel\Entity\DesignPackageAsset */
        foreach($resultSet as $asset){
            if($asset->isEnabled()){
                $queue->insert($asset,$asset->getPriority());
            }
        }

        $tmp=[];
        if($queue->count()){
            $queue->top();
            while($queue->valid()){
                $tmp[]=$queue->current();
                $queue->next();
            }
        }
        return $tmp;
    }
}