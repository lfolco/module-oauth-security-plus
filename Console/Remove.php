<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Console;

use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Hawksama\OauthSecurityPlus\Command\Ip\DeleteByIpAddressCommand;

class Remove extends Command
{
    public function __construct(
        private readonly DeleteByIpAddressCommand $deleteByIp,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('hawksama:api-whitelist:remove');
        $this->setDescription('Remove IP(s) from the whitelist');
        $this->addArgument(
            'ips',
            InputArgument::IS_ARRAY,
            'IPs to remove'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $ips = $input->getArgument('ips');

        // If no IPs provided => throw error or remove all, up to you.
        if (empty($ips)) {
            throw new LocalizedException(__('Please provide at least one IP address to remove.'));
        }

        try {
            foreach ($ips as $ipAddress) {
                $this->deleteByIp->execute($ipAddress);
            }
        } catch (\Exception $e) {
            throw new LocalizedException(
                __('Error during IP removal: %1', $e->getMessage())
            );
        }

        $output->writeln(__("Successfully removed specified IP(s).")->render());
        return Command::SUCCESS;
    }
}
