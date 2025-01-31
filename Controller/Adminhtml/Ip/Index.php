<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Controller\Adminhtml\Ip;

use Hawksama\OauthSecurityPlus\Controller\Adminhtml\Controller;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * IP backend index (list) controller.
 */
class Index extends Controller implements HttpGetActionInterface
{
    public function execute(): ResultInterface|ResponseInterface
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('Hawksama_OauthSecurityPlus::management');
        $resultPage->getConfig()->getTitle()->prepend(__('IP List')->render());

        return $resultPage;
    }
}
