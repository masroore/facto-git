<?php

namespace App\Console\Commands;

use App\Cat;
use App\Banner;
use App\Episode;
use App\Webtoon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MakeList extends Command
{

    protected $signature = 'make:list';

    protected $description = '리스트 페이지 우측의 리스트들 만들기';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        dd('aaa');
        
    }
}
