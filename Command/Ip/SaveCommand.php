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
use Magento\Framework\Exception\CouldNotSaveException;
use Psr\Log\LoggerInterface;

/**
 * Save IP Command.
 */
class SaveCommand
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly IpModelFactory $modelFactory,
        private readonly IpResource $resource
    ) {
    }

    /**
     * Save IP.
     *
     * @param IpInterface $ip
     * @return int
     * @throws CouldNotSaveException
     */
    public function execute(IpInterface $ip): int
    {
        try {
            /** @var IpModel $model */
            $model = $this->modelFactory->create();
            /** @var IpModel $ip */
            $model->addData($ip->getData());
            $model->setHasDataChanges(true);

            if (!$model->getData(IpInterface::IP_ID)) {
                $model->isObjectNew(true);
            }
            $this->resource->save($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not save IP. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotSaveException(__('Could not save IP.'));
        }

        return (int)$model->getData(IpInterface::IP_ID);
    }
}
