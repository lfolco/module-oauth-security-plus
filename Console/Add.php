<?php

/**
 * Copyright © Alexandru-Manuel Carabus All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Hawksama\OauthSecurityPlus\Console;

use Hawksama\OauthSecurityPlus\Api\Data\IpInterface;
use Hawksama\OauthSecurityPlus\Api\Data\IpInterfaceFactory;
use Hawksama\OauthSecurityPlus\Api\IpRepositoryInterface;
use Hawksama\OauthSecurityPlus\Command\Ip\SaveCommand;
use Hawksama\OauthSecurityPlus\Model\IpModel;
use Hawksama\OauthSecurityPlus\Model\IpModelFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI Command: Add IP(s) to the API whitelist.
 */
class Add extends Command
{
    public function __construct(
        private readonly IpRepositoryInterface $ipRepository,
        private readonly SaveCommand $saveCommand,
        private readonly IpInterfaceFactory $entityDataFactory,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('hawksama:api-whitelist:add')
            ->setDescription('Add IP(s) to the API whitelist')
            ->addArgument(
                'ips',
                InputArgument::IS_ARRAY,
                'List of IPs to add'
            );
    }

    /**
     * @throws CouldNotSaveException
     * @throws LocalizedException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $ips = $input->getArgument('ips');
        if (empty($ips)) {
            throw new LocalizedException(__('At least one IP should be provided!'));
        }

        $addedIps = [];
        foreach ($ips as $newIp) {
            /** @var IpModel|null $existing */
            $existing = $this->ipRepository->getByIp($newIp);

            if ($existing) {
                // Re-enable if disabled
                $existing->setData(IpInterface::ENABLED, 1);
                $this->saveCommand->execute($existing);
                $output->writeln(
                    __("The IP %1 was already in the whitelist but has been re-enabled.", [$newIp])->render()
                );
                continue;
            }

            /** @var IpModel $ipModel */
            $ipModel = $this->entityDataFactory->create();
            $ipModel->setData(IpInterface::IP_NAME, 'Created via CLI');
            $ipModel->setData(IpInterface::IP_ADDRESS, $newIp);
            $ipModel->setData(IpInterface::ENABLED, 1);

            $this->saveCommand->execute($ipModel);
            $addedIps[] = $newIp;
        }

        if (!empty($addedIps)) {
            $output->writeln(
                __(
                    "Successfully added the following IPs to the whitelist: %1",
                    [implode(', ', $addedIps)]
                )->render()
            );
        }

        return Command::SUCCESS;
    }
}
