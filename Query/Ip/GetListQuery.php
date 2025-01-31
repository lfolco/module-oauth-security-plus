<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Query\Ip;

use Hawksama\OauthSecurityPlus\Mapper\IpDataMapper;
use Hawksama\OauthSecurityPlus\Model\ResourceModel\IpModel\IpCollection;
use Hawksama\OauthSecurityPlus\Model\ResourceModel\IpModel\IpCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;

/**
 * Get IP list by search criteria query.
 */
class GetListQuery
{
    public function __construct(
        private readonly CollectionProcessorInterface  $collectionProcessor,
        private readonly IpCollectionFactory           $entityCollectionFactory,
        private readonly IpDataMapper                  $entityDataMapper,
        private readonly SearchCriteriaBuilder         $searchCriteriaBuilder,
        private readonly SearchResultsInterfaceFactory $searchResultFactory
    ) {
    }

    /**
     * Get IP list by search criteria.
     */
    public function execute(?SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
    {
        /** @var IpCollection $collection */
        $collection = $this->entityCollectionFactory->create();

        if ($searchCriteria === null) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        }

        $this->collectionProcessor->process($searchCriteria, $collection);

        $entityDataObjects = $this->entityDataMapper->map($collection);

        /** @var SearchResultsInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($entityDataObjects);
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }
}
