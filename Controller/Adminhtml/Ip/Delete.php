<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Controller\Adminhtml\Ip;

use Hawksama\OauthSecurityPlus\Controller\Adminhtml\Controller;
use Hawksama\OauthSecurityPlus\Api\Data\IpInterface;
use Hawksama\OauthSecurityPlus\Model\IpModelFactory;
use Hawksama\OauthSecurityPlus\Model\ResourceModel\IpResource;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;

class Delete extends Controller implements HttpPostActionInterface, HttpGetActionInterface
{
    public function __construct(
        Context $context,
        private readonly IpModelFactory $modelFactory,
        private readonly IpResource $resource,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/');
        $entityId = (int)$this->getRequest()->getParam(IpInterface::IP_ID);

        try {
            $model = $this->modelFactory->create();
            $this->resource->load($model, $entityId, IpInterface::IP_ID);

            if (!$model->getId()) {
                throw new NoSuchEntityException(
                    __('Could not find IP with id: %1', $entityId)
                );
            }

            $this->resource->delete($model);
            $this->messageManager->addSuccessMessage(
                __('You have successfully deleted the IP entity.')->render()
            );
        } catch (NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        } catch (\Exception $exception) {
            $this->logger->error(
                __('Could not delete IP. Original message: %1', $exception->getMessage())->render(),
                ['exception' => $exception]
            );
            $this->messageManager->addErrorMessage(__('An error occurred while deleting the IP.')->render());
        }

        return $resultRedirect;
    }
}
