<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

#[Signature('sitemap:generate')]
#[Description('Generate the sitemap.xml file')]
class GenerateSitemapCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting sitemap generation...');

        $sitemap = Sitemap::create();

        // Add all static pages
        $sitemap->add(Url::create(route('home'))
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        $sitemap->add(Url::create(route('catalog'))
            ->setPriority(0.9)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));

        $sitemap->add(Url::create(route('video'))
            ->setPriority(0.8)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));

        $sitemap->add(Url::create(route('calculator'))
            ->setPriority(0.8)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        $sitemap->add(Url::create(route('ecosystem'))
            ->setPriority(0.7)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        $sitemap->add(Url::create(route('delivery-payment'))
            ->setPriority(0.6)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        $sitemap->add(Url::create(route('warranty'))
            ->setPriority(0.6)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        $sitemap->add(Url::create(route('privacy'))
            ->setPriority(0.5)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        $sitemap->add(Url::create(route('terms'))
            ->setPriority(0.5)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        // Save to public/sitemap.xml
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap successfully generated and saved to '.public_path('sitemap.xml'));

        return self::SUCCESS;
    }
}
