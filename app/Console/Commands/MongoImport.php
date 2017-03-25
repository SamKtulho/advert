<?php

namespace App\Console\Commands;

use App\Advert;
use Illuminate\Console\Command;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

class MongoImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mongo:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $config = new LexerConfig();
        $lexer = new Lexer($config);

        $interpreter = new Interpreter();

        $i = 0;
        $interpreter->addObserver(function(array $columns) use(&$i) {
            ++$i;
            if ($columns[0] === 'simple_sku') return;
            $resUrl = '';
            $url = (explode('&', parse_url($columns[14], PHP_URL_QUERY)));
            foreach ($url as $item) {
                $res = explode('=', $item);
                if ($res[0] === 'url') {
                    $resUrl = urldecode($res[1]);
                    $resUrl = explode('?', $resUrl)[0];
                    continue;
                }
            }

            if (empty($resUrl)) {
                return;
            }

            $advert = new Advert();
            $advert->title = $columns[1];
            $advert->description = '';
            $advert->url = $resUrl;
            $advert->price = $columns[2];
            $advert->discounted_price = $columns[3];
            $advert->discounted_percentage = $columns[4];
            $advert->currency = $columns[5];
            $advert->category1 = $columns[6];
            $advert->category2 = $columns[7];
            $advert->category3 = $columns[8];
            $advert->picture = $columns[9];
            $advert->brand = $columns[15];
            $advert->save();

        });

        $lexer->parse('feed_all.csv', $interpreter);
    }
}
