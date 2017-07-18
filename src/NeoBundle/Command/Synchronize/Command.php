<?php

namespace NeoBundle\Command\Synchronize;

use Carbon\Carbon;
use InvalidArgumentException;
use NeoBundle\Command\Synchronize\Integration\NeoWebService\NeoProviderInterface;
use NeoBundle\Entity\Repository\NeoRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('neo:synchronize')
            ->setDescription('Synchronize data between our database and NASA source for the last several days.')
            ->addArgument(
                'startDate',
                InputArgument::OPTIONAL,
                'A start of the synchronization process. By default 3 days from now. The max range in one query is '
                . '7 days. Format: Y-m-d.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startDate = $this->convertStartDateFrom($input);
        $listOfNeoResponses = $this->getNeoProvider()->getNeoBetweenDates($startDate, Carbon::now('UTC'));
        $listOfNeo = [];
        foreach ($listOfNeoResponses as $neoResponse) {
            if (!$neo = $this->getMapper()->map($neoResponse)) {
                continue;
            }

            $listOfNeo[] = $neo;
        }
        $this->getNeoRepository()->saveBatch(...$listOfNeo);

        $output->writeln(sprintf('Synchronized %d objects.', count($listOfNeo)));
    }


    private function convertStartDateFrom(InputInterface $input)
    {
        try {
            if ($startDate = $input->getArgument('startDate')) {
                return Carbon::createFromFormat('Y-m-d', $startDate, 'UTC')->startOfDay();
            }
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException('Argument is not a valid date. Valid format: Y-m-d.');
        }

        return Carbon::now('UTC')->subDays(3)->startOfDay();
    }

    /**
     * @return NeoProviderInterface
     */
    private function getNeoProvider()
    {
        return $this->getContainer()->get('command.synchronize.integration.api.neo_provider');
    }

    /**
     * @return Mapper
     */
    private function getMapper()
    {
        return $this->getContainer()->get('command.synchronize.mapper');
    }

    /**
     * @return NeoRepository
     */
    private function getNeoRepository()
    {
        return $this->getContainer()->get('neo.repository.neo');
    }
}
