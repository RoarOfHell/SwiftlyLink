<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Создание нового объекта Sitemap
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setLastModificationDate(now()))
            // Добавьте больше URL по вашему усмотрению
            ;

        // Запись Sitemap в файл
        $sitemap->writeToFile(public_path('sitemap.xml'));

        // Вывод сообщения о завершении
        $this->info('Sitemap generated successfully!');
    }
}