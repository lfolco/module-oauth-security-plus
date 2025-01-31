<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Mapper;

use Hawksama\OauthSecurityPlus\Api\Data\IpInterface;
use Hawksama\OauthSecurityPlus\Api\Data\IpInterfaceFactory;
use Hawksama\OauthSecurityPlus\Model\IpModel;
use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Converts a collection of IP entities to an array of data transfer objects.
 */
class IpDataMapper
{
    public function __construct(
        private readonly IpInterfaceFactory $entityDtoFactory
    ) {
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     * @return ExtensibleDataInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var IpModel $item */
        foreach ($collection->getItems() as $item) {
            /** @var IpModel $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }

        /** @var ExtensibleDataInterface[] $results */
        return $results;
    }
}
