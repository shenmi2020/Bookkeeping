<?php

namespace app\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use support\Db;

class DbMockCommand extends Command
{
    protected static $defaultName = 'db:mock';
    protected static $defaultDescription = 'db mock';

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
        $start_date = 1642486045;
        $end_date = 1647583645;
        for ($i = 1000; $i > 0; $i--) {
            $date = date('Y-m-d', mt_rand($start_date, $end_date));
            $cate_id = mt_rand(1, 5);
            $cate_info = Db::table('category')->where('id', $cate_id)->first();

            $name = $this->getChar(mt_rand(3, 6));
            Db::table('record')->insert([
                'category_id' => $cate_info->id,
                'category_name' => $cate_info->title,
                'day' => $date,
                'remark' => $name,
                'aid' => 1,
                'money' => mt_rand(10, 200),
                'uid' => 1,
                'type' => mt_rand(1, 2),
                'create_time' => time()
            ]);
            
            $output->writeln('Hello db:mock: '.$name);
        }
        return self::SUCCESS;
    }

    private function getChar($num)  // $num为生成汉字的数量
    {
        $b = '';
        for ($i=0; $i<$num; $i++) {
            // 使用chr()函数拼接双字节汉字，前一个chr()为高位字节，后一个为低位字节
            $a = chr(mt_rand(0xB0,0xD0)).chr(mt_rand(0xA1, 0xF0));
            // 转码
            $b .= iconv('GB2312', 'UTF-8', $a);
        }
        return $b;
    }

}
