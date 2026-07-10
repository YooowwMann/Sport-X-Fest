<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title'       => 'Marathon Nasional 2026',
                'description' => 'Lari marathon sejauh 42km melintasi jalur ikonik Jakarta. Terbuka untuk semua kalangan usia 18 tahun ke atas.',
                'date'        => '2026-08-15',
                'location'    => 'Monas, Jakarta Pusat',
                'quota'       => 500,
                'image'       => null,
                'status'      => 'open',
            ],
            [
                'title'       => 'Fun Run 5K SportXFest',
                'description' => 'Lari santai 5km yang menyenangkan untuk seluruh keluarga. Tersedia kategori pria, wanita, dan junior.',
                'date'        => '2026-08-22',
                'location'    => 'GBK, Senayan, Jakarta',
                'quota'       => 1000,
                'image'       => null,
                'status'      => 'open',
            ],
            [
                'title'       => 'Half Marathon Bandung',
                'description' => 'Lari setengah marathon 21km di kota kembang Bandung dengan pemandangan alam yang memukau.',
                'date'        => '2026-09-05',
                'location'    => 'Alun-alun Bandung, Jawa Barat',
                'quota'       => 300,
                'image'       => null,
                'status'      => 'open',
            ],
            [
                'title'       => 'Trail Run Puncak 10K',
                'description' => 'Lari lintas alam di kawasan Puncak Bogor. Jalur menantang dengan pemandangan perkebunan teh yang indah.',
                'date'        => '2026-09-20',
                'location'    => 'Puncak, Bogor, Jawa Barat',
                'quota'       => 200,
                'image'       => null,
                'status'      => 'open',
            ],
            [
                'title'       => 'Sprint Challenge 100m',
                'description' => 'Kompetisi lari cepat 100 meter untuk para atlet muda. Hadiah total senilai Rp 50 juta.',
                'date'        => '2026-10-10',
                'location'    => 'Stadion Manahan, Solo',
                'quota'       => 150,
                'image'       => null,
                'status'      => 'open',
            ],
            [
                'title'       => 'Night Run Jakarta 2026',
                'description' => 'Lari malam hari sejauh 10km dengan efek lampu warna-warni di sepanjang jalur. Pengalaman berlari yang unik dan seru!',
                'date'        => '2026-10-31',
                'location'    => 'Taman Menteng, Jakarta Pusat',
                'quota'       => 750,
                'image'       => null,
                'status'      => 'open',
            ],
            [
                'title'       => 'Charity Run Surabaya',
                'description' => 'Event lari amal untuk mendukung pendidikan anak kurang mampu. Setiap pendaftar berkontribusi Rp 50.000 untuk beasiswa.',
                'date'        => '2026-11-08',
                'location'    => 'Taman Bungkul, Surabaya',
                'quota'       => 400,
                'image'       => null,
                'status'      => 'open',
            ],
            [
                'title'       => 'Classic Marathon 2025 (Arsip)',
                'description' => 'Event marathon tahun lalu yang telah selesai diselenggarakan.',
                'date'        => '2025-12-01',
                'location'    => 'Jakarta',
                'quota'       => 300,
                'image'       => null,
                'status'      => 'closed',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }

        $this->command->info('✅ ' . count($events) . ' event berhasil dibuat (7 open, 1 closed)');
    }
}
