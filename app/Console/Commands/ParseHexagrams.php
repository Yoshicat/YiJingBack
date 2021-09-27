<?php

namespace App\Console\Commands;

use App\Models\Hexagram;
use Illuminate\Console\Command;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ParseHexagrams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hexa:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse hexagrams from http://happy-year.narod.ru/gadaniya/kniga';

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
     * @return int
     */
    public function handle()
    {
        Hexagram::truncate();

        for ($k = 1; $k < 65; $k++) {
            $response = Http::get('http://happy-year.narod.ru/gadaniya/kniga/kniga' . $k . '.html');

            preg_match_all("/<h3>.*?([0-9]{1,2})\.(.*?)<\/h3>\n<p.*?\/([d|k]{3})\.gif.*?\/([d|k]{3})\.gif.*<\/p>\n<p>([\d\D\r\n]+)<\/p>\n<p/", $response, $match);

            try {
                $hexa = new Hexagram();
                $hexa->id = (int)bindec(str_replace(['d', 'k'], [1, 0], strrev(trim($match[3][0])) . strrev(trim($match[4][0])))) + 1;
                $hexa->name = trim($match[1][0]) . ". " . trim($match[2][0]);
                $hexa->description = trim($match[5][0]);
                $hexa->save();
            } catch (\Exception $exception) {
                echo $k . " -> " . $exception->getMessage() . "\n";
            }
        }

        return 0;
    }
}
