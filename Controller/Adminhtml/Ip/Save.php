<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Controller\Adminhtml\Ip;

use Hawksama\OauthSecurityPlus\Api\Data\IpInterface;
use Hawksama\OauthSecurityPlus\Api\Data\IpInterfaceFactory;
use Hawksama\OauthSecurityPlus\Command\Ip\SaveCommand;
use Hawksama\OauthSecurityPlus\Controller\Adminhtml\Controller;
use Hawksama\OauthSecurityPlus\Model\IpModel;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Save IP controller action.
 */
class Save extends Controller implements HttpPostActionInterface
{
    public function __construct(
        Context $context,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly SaveCommand $saveCommand,
        private readonly IpInterfaceFactory $entityDataFactory
    ) {
        parent::__construct($context);
    }

    /**
     * Save IP Action.
     */
    public function execute(): ResultInterface|ResponseInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getParams();

        try {
            /** @var IpModel $entityModel */
            $entityModel = $this->entityDataFactory->create();
            $entityModel->addData($params['general']);
            $this->saveCommand->execute($entityModel);
            $this->messageManager->addSuccessMessage(
                __('The IP was saved successfully')->render()
            );
            $this->dataPersistor->clear('entity');
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $this->dataPersistor->set('entity', $params);

            return $resultRedirect->setPath('*/*/edit', [
                IpInterface::IP_ID => $this->getRequest()->getParam(IpInterface::IP_ID)
            ]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
