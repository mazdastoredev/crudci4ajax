<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = ['name', 'price', 'stock'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name'  => 'required|min_length[2]|max_length[150]',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
    ];

    protected $validationMessages = [
        'name'  => [
            'required' => 'Nama wajib diisi',
        ],
        'price' => [
            'required' => 'Harga wajib diisi',
            'numeric'  => 'Harga harus angka',
        ],
        'stock' => [
            'required' => 'Stok wajib diisi',
            'integer'  => 'Stok harus bilangan bulat',
        ],
    ];
}
