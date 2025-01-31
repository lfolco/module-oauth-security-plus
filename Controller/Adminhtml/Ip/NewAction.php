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
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * New action IP controller.
 */
class NewAction extends Controller implements HttpGetActionInterface
{
    public function execute(): Page|ResultInterface
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Hawksama_OauthSecurityPlus::management');
        $resultPage->getConfig()->getTitle()->prepend(__('New IP')->render());

        return $resultPage;
    }
}
