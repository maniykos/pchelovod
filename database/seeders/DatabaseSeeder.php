<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Certificate;
use App\Models\ContactSetting;
use App\Models\GalleryItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        ContactSetting::updateOrCreate([], [
            'phone' => '+374 91 410 820', 'telegram' => 'honey_atelier', 'max_username' => 'honey_atelier', 'email' => 'hello@honey-atelier.am',
            'address_ru' => 'Керчь, Крым', 'address_en' => 'Kerch, Crimea',
            'working_hours_ru' => 'Ежедневно, 09:00–20:00', 'working_hours_en' => 'Every day, 09:00–20:00',
        ]);

        Product::query()->delete();
        Product::insert([
            ['title_ru' => 'Мёд в сотах', 'title_en' => 'Honeycomb', 'slug' => 'honeycomb', 'description_ru' => 'Натуральные соты с мёдом — ароматный продукт прямо из улья.', 'description_en' => 'Natural honeycomb with honey, straight from the hive.', 'price' => 1450, 'unit' => '500 г', 'image' => '/images/products/honeycomb.png', 'is_featured' => true, 'is_published' => true, 'sort_order' => 1],
            ['title_ru' => 'Светлый мёд · стекло', 'title_en' => 'Light honey · glass jar', 'slug' => 'light-honey-glass', 'description_ru' => 'Литровая стеклянная банка светлого мёда с мягким цветочным вкусом.', 'description_en' => 'One-liter glass jar of light honey with a soft floral taste.', 'price' => 1850, 'unit' => '1 л', 'image' => '/images/products/glass-light.png', 'is_featured' => true, 'is_published' => true, 'sort_order' => 2],
            ['title_ru' => 'Тёмный мёд · стекло', 'title_en' => 'Dark honey · glass jar', 'slug' => 'dark-honey-glass', 'description_ru' => 'Литровая стеклянная банка тёмного мёда с насыщенным ароматом и глубоким послевкусием.', 'description_en' => 'One-liter glass jar of dark honey with a rich aroma and deep finish.', 'price' => 1950, 'unit' => '1 л', 'image' => '/images/products/glass-dark.png', 'is_featured' => true, 'is_published' => true, 'sort_order' => 3],
            ['title_ru' => 'Светлый мёд · пластик', 'title_en' => 'Light honey · plastic jar', 'slug' => 'light-honey-plastic', 'description_ru' => 'Литровая пластиковая банка светлого мёда — удобно взять с собой.', 'description_en' => 'One-liter plastic jar of light honey, convenient to take with you.', 'price' => 1550, 'unit' => '1 л', 'image' => '/images/products/plastic-light.png', 'is_featured' => true, 'is_published' => true, 'sort_order' => 4],
            ['title_ru' => 'Тёмный мёд · пластик', 'title_en' => 'Dark honey · plastic jar', 'slug' => 'dark-honey-plastic', 'description_ru' => 'Литровая пластиковая банка тёмного мёда с выразительным лесным вкусом.', 'description_en' => 'One-liter plastic jar of dark honey with an expressive forest taste.', 'price' => 1650, 'unit' => '1 л', 'image' => '/images/products/plastic-dark.png', 'is_featured' => true, 'is_published' => true, 'sort_order' => 5],
        ]);

        BlogPost::query()->delete();
        BlogPost::insert([
            ['title_ru' => 'Почему настоящий мёд кристаллизуется', 'title_en' => 'Why real honey crystallises', 'slug' => 'why-real-honey-crystallises', 'excerpt_ru' => 'Кристаллы — это не недостаток, а естественный сезонный ритм хорошего мёда.', 'excerpt_en' => 'Crystals are not a flaw, but the natural seasonal rhythm of good honey.', 'body_ru' => '<p>Кристаллизация — естественный процесс, который зависит от сорта мёда, температуры и соотношения глюкозы и фруктозы.</p><p>Если мёд стал плотнее, его можно мягко прогреть на водяной бане. Мы рекомендуем не нагревать его выше 40 °C, чтобы сохранить аромат и природные свойства.</p>', 'body_en' => '<p>Crystallisation is a natural process influenced by the variety, temperature, and balance of glucose and fructose.</p><p>If your honey becomes thicker, warm it gently in a water bath. We recommend staying below 40 °C to preserve its aroma and character.</p>', 'image' => 'https://images.unsplash.com/photo-1471943311424-646960669fbc?auto=format&fit=crop&w=1400&q=88', 'published_at' => now()->subDays(4), 'is_published' => true],
            ['title_ru' => 'Как мы готовим ульи к зиме', 'title_en' => 'How we prepare the hives for winter', 'slug' => 'preparing-hives-for-winter', 'excerpt_ru' => 'Зима начинается ещё в конце лета: рассказываем о тихой работе пасеки.', 'excerpt_en' => 'Winter begins in late summer. Here is the quiet work behind a healthy apiary.', 'body_ru' => '<p>После последнего медосбора мы проверяем каждую семью, оставляем достаточно запасов и утепляем ульи так, чтобы пчёлам было спокойно в самые холодные ночи.</p><p>Здоровая пчела — главный урожай следующего сезона.</p>', 'body_en' => '<p>After the final harvest we check every colony, leave enough stores, and insulate the hives so the bees stay calm through the coldest nights.</p><p>A healthy bee is the most important harvest of the next season.</p>', 'image' => 'https://images.unsplash.com/photo-1498936178812-4b2e558d2937?auto=format&fit=crop&w=1400&q=88', 'published_at' => now()->subDays(13), 'is_published' => true],
        ]);

        GalleryItem::query()->delete();
        GalleryItem::insert([
            ['title_ru' => 'Первый свет над ульями', 'title_en' => 'First light over the hives', 'image' => 'https://images.unsplash.com/photo-1504208434309-cb69f4fe52b0?auto=format&fit=crop&w=1200&q=88', 'alt_ru' => 'Пчёлы и цветущий луг', 'alt_en' => 'Bees and a flowering meadow', 'sort_order' => 1, 'is_published' => true],
            ['title_ru' => 'Соты нового сезона', 'title_en' => 'New season comb', 'image' => 'https://images.unsplash.com/photo-1473973266408-ed4e27abdd47?auto=format&fit=crop&w=1200&q=88', 'alt_ru' => 'Банка мёда на деревянном столе', 'alt_en' => 'Honey jar on a wooden table', 'sort_order' => 2, 'is_published' => true],
            ['title_ru' => 'Полевые травы', 'title_en' => 'Meadow herbs', 'image' => 'https://images.unsplash.com/photo-1497250681960-ef046c08a56e?auto=format&fit=crop&w=1200&q=88', 'alt_ru' => 'Зелёные травы', 'alt_en' => 'Green meadow herbs', 'sort_order' => 3, 'is_published' => true],
            ['title_ru' => 'Работа в саду', 'title_en' => 'Working in the orchard', 'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=88', 'alt_ru' => 'Цветы и сад', 'alt_en' => 'Flowers in the orchard', 'sort_order' => 4, 'is_published' => true],
            ['title_ru' => 'Тёплый урожай', 'title_en' => 'A warm harvest', 'image' => 'https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?auto=format&fit=crop&w=1200&q=88', 'alt_ru' => 'Мёд и деревянная ложка', 'alt_en' => 'Honey and wooden spoon', 'sort_order' => 5, 'is_published' => true],
        ]);

        Certificate::query()->delete();
        Certificate::insert([
            ['title_ru' => 'Натуральный продукт', 'title_en' => 'Natural product', 'issuer' => 'Crimea Quality Control', 'year' => 2025, 'image' => 'https://images.unsplash.com/photo-1577083552431-6e5fd01988a5?auto=format&fit=crop&w=900&q=88', 'description_ru' => 'Подтверждение соответствия требованиям к натуральному мёду.', 'description_en' => 'Confirmation of compliance with natural honey requirements.', 'sort_order' => 1],
            ['title_ru' => 'Лучший локальный бренд', 'title_en' => 'Best local brand', 'issuer' => 'Crimea Taste Awards', 'year' => 2024, 'image' => 'https://images.unsplash.com/photo-1564399579883-451a5d44ec08?auto=format&fit=crop&w=900&q=88', 'description_ru' => 'Награда за вкус и бережное производство.', 'description_en' => 'Award for taste and thoughtful production.', 'sort_order' => 2],
        ]);
    }
}
