<?php

namespace app\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;


class DbConfigCommand extends Command
{
    protected static $defaultName = 'db:config';
    protected static $defaultDescription = '显示当前MySQL服务器配置';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL, 'Name description');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('MySQL配置信息如下：');
        $config = config('database');
        $headers = ['name', 'default', 'driver', 'host', 'port', 'database', 'username', 'password', 'unix_socket', 'charset', 'collation', 'prefix', 'strict', 'engine', 'schema', 'sslmode'];
        $rows = [];
        foreach ($config['connections'] as $name => $db_config) {
            $row = [];
            foreach ($headers as $key) {
                switch ($key) {
                    case 'name':
                        $row[] = $name;
                        break;
                    case 'default':
                        $row[] = $config['default'] == $name ? 'true' : 'false';
                        break;
                    default:
                        $row[] = $db_config[$key] ?? '';
                }
            }
            if ($config['default'] == $name) {
                array_unshift($rows, $row);
            } else {
                $rows[] = $row;
            }
        }
        $table = new Table($output);
        $table->setHeaders($headers);
        $table->setRows($rows);
        $table->render();
        return self::SUCCESS;
    }

}
