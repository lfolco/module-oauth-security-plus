<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Model;

use Hawksama\OauthSecurityPlus\Api\Data\IpInterface;
use Hawksama\OauthSecurityPlus\Api\IpRepositoryInterface;
use Hawksama\OauthSecurityPlus\Model\IpModel;
use Hawksama\OauthSecurityPlus\Model\ResourceModel\IpModel\IpCollection;
use Hawksama\OauthSecurityPlus\Model\ResourceModel\IpModel\IpCollectionFactory;
use Hawksama\OauthSecurityPlus\Model\ResourceModel\IpResource;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Model\AbstractModel;

class IpRepository implements IpRepositoryInterface
{
    public function __construct(
        private IpResource $ipResource,
        private IpCollectionFactory $collectionFactory
    ) {
    }

    public function save(AbstractModel $ip): AbstractModel
    {
        try {
            $this->ipResource->save($ip);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $ip;
    }

    public function getByIp(string $ipAddress): ?IpModel
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('ip_address', $ipAddress);

        /** @var IpModel $item */
        $item = $collection->getFirstItem();
        if (!$item->getIpId()) {
            return null;
        }
        return $item;
    }

    public function getAll(): array
    {
        return $this->collectionFactory->create()->getItems();
    }

    public function getAllEnabled(): array
    {
        /** @var IpCollection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('enabled', "1");
        return $collection->getItems();
    }

    /**
     * @throws \Exception
     */
    public function delete(IpModel $ip): void
    {
        $this->ipResource->delete($ip);
    }

    public function deleteByIp(string $ipAddress): void
    {
        $ip = $this->getByIp($ipAddress);
        if ($ip !== null) {
            $this->delete($ip);
        }
    }
}
