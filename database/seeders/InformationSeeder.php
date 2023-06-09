<?php

namespace Database\Seeders;

use App\Models\Information;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Information::create([
            'vk_url' => 'https://vk.com/rosmolodez',
            'vk_description' => 'Это наша страница вконтакте, заходи и подпишись, там много интересного.',
            'tg_url' => 'https://t.me/+zkLRoaZN43JmN2Uyrosmolodez',
            'tg_description' => 'Это телеграм бот, мы связываем вас с вашим куратором и постоянно обеспечиваем вас мотивацией.',
            'zen_url' => 'https://zen.yandex.ru/',
            'zen_description' => 'Это наш дзен аккаунт, там появляются интересные статьи от наших кураторов и лидеров мнений.',
            'location' => 'г.Курган, ул.Куйбышева, 36',
            'location_description' => 'Мы находимся по этому адресу временно, по этому мы там находимся и мы там есть.',
            'location_url' => 'https://yandex.ru/map-widget/v1/?um=constructor%3A5c25d6c40b3c23077a48eb1c59d26a9c8521e83ada556b46c085d2ea3090a654&source=constructor',

        ]);
    }
}
