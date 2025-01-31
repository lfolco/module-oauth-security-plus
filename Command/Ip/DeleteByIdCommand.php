<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Command\Ip;

use Exception;
use Hawksama\OauthSecurityPlus\Api\Data\IpInterface;
use Hawksama\OauthSecurityPlus\Model\IpModel;
use Hawksama\OauthSecurityPlus\Model\IpModelFactory;
use Hawksama\OauthSecurityPlus\Model\ResourceModel\IpResource;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

/**
 * Delete IP by id Command.
 */
class DeleteByIdCommand
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly IpModelFactory $modelFactory,
        private readonly IpResource $resource
    ) {
    }

    /**
     * Delete IP.
     *
     * @param int $entityId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $entityId): void
    {
        try {
            /** @var IpModel $model */
            $model = $this->modelFactory->create();
            $this->resource->load($model, $entityId, IpInterface::IP_ID);

            if (!$model->getData(IpInterface::IP_ID)) {
                throw new NoSuchEntityException(
                    __(
                        'Could not find IP with id: `%id`',
                        [
                            'id' => $entityId
                        ]
                    )
                );
            }

            $this->resource->delete($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not delete IP. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotDeleteException(__('Could not delete IP.'));
        }
    }
}
