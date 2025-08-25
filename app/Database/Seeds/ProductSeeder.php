<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Pulpen', 'price' => 3500, 'stock' => 100],
            ['name' => 'Buku Tulis', 'price' => 12000, 'stock' => 50],
            ['name' => 'Penggaris', 'price' => 7000, 'stock' => 30],
        ];
        $this->db->table('products')->insertBatch($data);
    }
}
