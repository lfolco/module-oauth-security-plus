<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Block\Adminhtml\Form\Ip;

use Hawksama\OauthSecurityPlus\Api\Data\IpInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Delete entity button.
 */
class Delete extends GenericButton implements ButtonProviderInterface
{
    /**
     * Retrieve Delete button settings.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        if (!$this->getIpId()) {
            return [];
        }

        return $this->wrapButtonSettings(
            __('Delete')->getText(),
            'delete',
            sprintf(
                "deleteConfirm('%s', '%s')",
                __('Are you sure you want to delete this IP?'),
                $this->getUrl(
                    '*/*/delete',
                    [IpInterface::IP_ID => $this->getIpId()]
                )
            ),
            [],
            20
        );
    }
}
