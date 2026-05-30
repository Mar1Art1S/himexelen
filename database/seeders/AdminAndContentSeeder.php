<?php

namespace Database\Seeders;

use App\Models\Instruction;
use App\Models\ProductCategory;
use App\Models\ProductComplectation;
use App\Models\ProductComponent;
use App\Models\Size;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAndContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Default Admin User if not exists
        if (! User::where('email', 'admin@himexelen.test')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@himexelen.test',
                'password' => Hash::make('admin12345'),
            ]);
        }

        // 2. Seed Video Categories and Videos
        $generalCategory = VideoCategory::updateOrCreate(
            ['slug' => 'zahalni-ohliady'],
            [
                'name' => 'Загальні огляди',
                'type' => 'general',
                'sort_order' => 10,
            ]
        );

        $assemblyCategory = VideoCategory::updateOrCreate(
            ['slug' => 'zbirka-elementiv-vulyka'],
            [
                'name' => 'Збірка елементів вулика',
                'type' => 'assembly',
                'sort_order' => 20,
            ]
        );

        $generalVideos = [
            ['title' => 'Огляд вуликів з ППУ', 'id' => 'PN5ktKn3dTM'],
            ['title' => 'Вулик на 8 рамок', 'id' => 'EcEZlWO9kZU'],
            ['title' => 'Вулик на 10 рамок', 'id' => 'qV5P6EC41n8'],
            ['title' => 'Вулик на 12 рамок', 'id' => '88AP8UWpScU'],
            ['title' => 'Підготовка до сезону', 'id' => 'GLGJfwQF6HE'],
            ['title' => 'Догляд та експлуатація', 'id' => 'Gw4ZMDmF--Y'],
            ['title' => 'Збірка 10-рамочного вулика ТМ "Хімекселен"', 'id' => 't-RntQH6BKk'],
            ['title' => 'Переваги 8-рамочного вулика ТМ "Хімекселен"', 'id' => 'FQbLXRikJs4'],
            ['title' => 'Система вентиляції вуликів з ППУ ТМ "Хімекселен"', 'id' => 'wVgB5nN1_eE'],
            ['title' => 'Фарбування вуликів з ППУ ТМ "Хімекселен"', 'id' => 'A2uvHpNLQIg'],
            ['title' => 'Транспортування вуликів з ППУ ТМ "Хімекселен"', 'id' => 'nfadkyiC1dA'],
            ['title' => 'Політерм-1600. Мобільна установка для напилення пінополіуретану', 'id' => '6V-jIzitYCM'],
        ];

        foreach ($generalVideos as $index => $v) {
            Video::updateOrCreate(
                ['youtube_id' => $v['id'], 'video_category_id' => $generalCategory->id],
                ['title' => $v['title'], 'sort_order' => ($index + 1) * 10]
            );
        }

        $assemblyVideos = [
            ['title' => 'Збірка дна вулика 8-рамочного ТМ "Хімекселен"', 'id' => 'X_PPJdfHMFA'],
            ['title' => 'Збірка корпусу 145 вулика 8-рамочного ТМ "Хімекселен"', 'id' => 'TApO1IoBCok'],
            ['title' => 'Збірка корпусу 230 вулика 8-рамочного ТМ "Хімекселен"', 'id' => 'e4BEjlRz-CU'],
            ['title' => 'Збірка корпусу 300 вулика 8-рамочного ТМ "Хімекселен"', 'id' => '4QqDPew2z0U'],
            ['title' => 'Збірка криші вулика 8-рамочного ТМ "Хімекселен"', 'id' => 'pNT9XXGoNf4'],
            ['title' => 'Збірка годівниці вулика 8-рамочного ТМ "Хімекселен"', 'id' => 'oGYW3VwWTSQ'],
            ['title' => 'Збірка заставної вулика 8-рамочного ТМ "Хімекселен"', 'id' => 'IN9pnXKFPYg'],
            ['title' => 'Збірка підрамкового загороджувача вулика 8-рамочного ТМ "Хімекселен"', 'id' => '5MY12RHwt7o'],
        ];

        foreach ($assemblyVideos as $index => $v) {
            Video::updateOrCreate(
                ['youtube_id' => $v['id'], 'video_category_id' => $assemblyCategory->id],
                ['title' => $v['title'], 'sort_order' => ($index + 1) * 10]
            );
        }

        // 3. Seed Instructions
        $instructions = [
            [
                'title' => 'Інструкція для 8-рамкового вулика',
                'image' => 'instruction-8ua-pdf.jpg',
                'pdf' => 'instruction-8ua.pdf',
                'label' => '8 рамок',
            ],
            [
                'title' => 'Інструкція для 10-рамкового вулика',
                'image' => 'instruction-10ua-pdf.jpg',
                'pdf' => 'instruction-10ua.pdf',
                'label' => '10 рамок',
            ],
            [
                'title' => 'Інструкція для 12-рамкового вулика',
                'image' => 'instruction-12ua-pdf.jpg',
                'pdf' => 'instruction-12ua.pdf',
                'label' => '12 рамок',
            ],
        ];

        foreach ($instructions as $index => $inst) {
            Instruction::updateOrCreate(
                ['pdf' => $inst['pdf']],
                [
                    'title' => $inst['title'],
                    'image' => $inst['image'],
                    'label' => $inst['label'],
                    'sort_order' => ($index + 1) * 10,
                ]
            );
        }

        // 4. Seed Sizes
        $frames = [
            ['title' => 'Рамка 145', 'image' => 'frame_145.jpg', 'description' => 'Креслення для магазину або надставки 145 мм.'],
            ['title' => 'Рамка 230', 'image' => 'frame_230.jpg', 'description' => 'Креслення корпусу під рамку 230 мм.'],
            ['title' => 'Рамка 300', 'image' => 'frame_300.jpg', 'description' => 'Креслення корпусу під рамку 300 мм.'],
        ];

        foreach ($frames as $index => $f) {
            Size::updateOrCreate(
                ['title' => $f['title'], 'type' => 'frame'],
                [
                    'image' => $f['image'],
                    'description' => $f['description'],
                    'sort_order' => ($index + 1) * 10,
                ]
            );
        }

        $sets = [
            ['title' => 'Комплектація 8 рамок', 'image' => 'bee8-compl.png'],
            ['title' => 'Комплектація 10/12 рамок', 'image' => 'bee10-12-compl.png'],
        ];

        foreach ($sets as $index => $s) {
            Size::updateOrCreate(
                ['title' => $s['title'], 'type' => 'set'],
                [
                    'image' => $s['image'],
                    'description' => null,
                    'sort_order' => ($index + 1) * 10,
                ]
            );
        }

        $priceImages = [
            ['title' => '8 рамок', 'image' => 'bee8-price.png'],
            ['title' => '10 рамок', 'image' => 'bee10-price.png'],
            ['title' => '12 рамок', 'image' => 'bee12-price.png'],
        ];

        foreach ($priceImages as $index => $p) {
            Size::updateOrCreate(
                ['title' => $p['title'], 'type' => 'price_image'],
                [
                    'image' => $p['image'],
                    'description' => null,
                    'sort_order' => ($index + 1) * 10,
                ]
            );
        }

        // 5. Seed Product Catalog Categories, Complectations & Components from CSV
        $cat8 = ProductCategory::updateOrCreate(['slug' => '8-frames'], ['name' => '8-рамкові вулики']);
        $cat10 = ProductCategory::updateOrCreate(['slug' => '10-frames'], ['name' => '10-рамкові вулики']);
        $cat12 = ProductCategory::updateOrCreate(['slug' => '12-frames'], ['name' => '12-рамкові вулики']);
        $catOther = ProductCategory::updateOrCreate(['slug' => 'other'], ['name' => 'Комплектуючі (інше)']);

        $csvPath = base_path('resources/прайс.csv');
        if (file_exists($csvPath)) {
            $file = fopen($csvPath, 'r');
            $rows = [];
            while (($data = fgetcsv($file, 0, ',', '"', '\\')) !== false) {
                $rows[] = $data;
            }
            fclose($file);

            $currentFrameSize = null;
            $currentPackageName = null;
            $currentPackagePrice = 0;
            $currentPackageDetails = [];
            $currentPackageComponents = [];

            $categoryMap = [
                '8' => $cat8->id,
                '10' => $cat10->id,
                '12' => $cat12->id,
                'інше' => $catOther->id,
            ];

            $componentGroup = null;
            $complectationIndex = 1;
            $componentIndex = 1;

            foreach ($rows as $rowIndex => $row) {
                $row = array_map('trim', $row);
                if ($rowIndex < 4) {
                    continue;
                }

                // Left side (Packages / Complectations)
                if (isset($row[0]) && preg_match('/Вулик\s+(\d+)-рамковий/u', $row[0], $matches)) {
                    if ($currentPackageName && $currentFrameSize) {
                        $catId = $categoryMap[$currentFrameSize] ?? $catOther->id;
                        ProductComplectation::updateOrCreate(
                            ['product_category_id' => $catId, 'name' => $currentPackageName],
                            [
                                'description' => implode(', ', $currentPackageDetails).'.',
                                'price' => $currentPackagePrice,
                                'components' => $currentPackageComponents,
                                'sort_order' => $complectationIndex++ * 10,
                            ]
                        );
                    }
                    $currentFrameSize = $matches[1];
                    $currentPackageName = null;
                    $currentPackagePrice = 0;
                    $currentPackageDetails = [];
                    $currentPackageComponents = [];
                } elseif (isset($row[0]) && preg_match('/Комплектація\s+(\d+)/u', $row[0], $matches)) {
                    if ($currentPackageName && $currentFrameSize) {
                        $catId = $categoryMap[$currentFrameSize] ?? $catOther->id;
                        ProductComplectation::updateOrCreate(
                            ['product_category_id' => $catId, 'name' => $currentPackageName],
                            [
                                'description' => implode(', ', $currentPackageDetails).'.',
                                'price' => $currentPackagePrice,
                                'components' => $currentPackageComponents,
                                'sort_order' => $complectationIndex++ * 10,
                            ]
                        );
                    }
                    $currentPackageName = $row[0];
                    $priceStr = isset($row[4]) ? str_replace([',', ' '], ['.', ''], $row[4]) : '0';
                    $currentPackagePrice = (int) round((float) $priceStr);
                    $currentPackageDetails = [];
                    $currentPackageComponents = [];

                    if (! empty($row[1])) {
                        $qty = ! empty($row[2]) ? $row[2] : '1';
                        $unit = ! empty($row[3]) ? $row[3] : 'шт';
                        $currentPackageDetails[] = "{$row[1]} ({$qty} {$unit})";
                        $currentPackageComponents[] = ['name' => $row[1], 'qty' => $qty, 'unit' => $unit];
                    }
                } else {
                    if ($currentFrameSize && $currentPackageName && ! empty($row[1])) {
                        $qty = ! empty($row[2]) ? $row[2] : '1';
                        $unit = ! empty($row[3]) ? $row[3] : 'шт';
                        $currentPackageDetails[] = "{$row[1]} ({$qty} {$unit})";
                        $currentPackageComponents[] = ['name' => $row[1], 'qty' => $qty, 'unit' => $unit];
                    }
                }

                // Right side (Components)
                if (! empty($row[8])) {
                    $col8 = $row[8];
                    if (preg_match('/^(\d+)-рамковий$/u', $col8, $groupMatches)) {
                        $componentGroup = $groupMatches[1];
                    } elseif ($col8 === 'інше') {
                        $componentGroup = 'інше';
                    } elseif (isset($row[9]) && trim($row[9]) !== '') {
                        $compName = $col8;
                        $compPriceStr = str_replace([',', ' '], ['.', ''], $row[9]);
                        $compPrice = (int) round((float) $compPriceStr);
                        $catId = $categoryMap[$componentGroup] ?? $catOther->id;

                        ProductComponent::updateOrCreate(
                            ['product_category_id' => $catId, 'name' => $compName],
                            [
                                'price' => $compPrice,
                                'group' => $componentGroup,
                                'sort_order' => $componentIndex++ * 10,
                            ]
                        );
                    }
                }
            }

            // Save last package
            if ($currentPackageName && $currentFrameSize) {
                $catId = $categoryMap[$currentFrameSize] ?? $catOther->id;
                ProductComplectation::updateOrCreate(
                    ['product_category_id' => $catId, 'name' => $currentPackageName],
                    [
                        'description' => implode(', ', $currentPackageDetails).'.',
                        'price' => $currentPackagePrice,
                        'components' => $currentPackageComponents,
                        'sort_order' => $complectationIndex++ * 10,
                    ]
                );
            }
        }
    }
}
