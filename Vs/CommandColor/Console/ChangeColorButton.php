<?php

namespace Vs\CommandColor\Console;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Variable\Model\VariableFactory;


class ChangeColorButton extends Command
{
    const COLOR = 'color';
    const STORE = 'store';

    protected $varFActory;


    public function __construct(VariableFactory $varFactory)
    {
        $this->varFActory = $varFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('scandiweb:color-change');
        $this->setDescription('Command to change color specials buttons.');
        $this->addOption(
            self::COLOR,
            null,
            InputOption::VALUE_REQUIRED,
            'Color HEXA'
        );
        $this->addOption(
            self::STORE,
            null,
            InputOption::VALUE_REQUIRED,
            'Store ID'
        );

        parent::configure();
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $color = $input->getOption(self::COLOR);
        $store = $input->getOption(self::STORE);
        if ($color) {
            
            $output->writeln('<info>Provided color is #`' . $color . '`</info>');
            $output->writeln('<info>Provided Store is #`' . $store . '`</info>');
        }

        $variable = $this->varFActory->create();

        $var = $variable->loadByCode('color_button_gral');
        $varValue = $var->getPlainValue();

        if(empty($varValue)){
            $output->writeln('<info>Creating Var</info>');
                $data = [
                'code' => 'color_button_gral',
                'name' => 'Color Button Global',
                'html_value' => '',
                'plain_value' => $color,
                ];
            $variable->setData($data);
            $variable->save();  
        }else{
            $output->writeln('<info>Editing Var</info>');
            $variable->setPlainValue($color)
                    ->setStoreId($store)
                    ->save();
        }

        $output->writeln('<info>Success</info>');

    }
}
