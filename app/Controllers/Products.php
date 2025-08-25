<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        helper(['form']);
    }

    public function index()
    {
        return view('products/index');
    }

    // READ: list JSON untuk table
    public function list()
    {
        $products = $this->productModel->findAll();
        return $this->response->setJSON($products);
    }

    // READ: detail satu row (untuk modal edit)
    public function show($id)
    {
        $row = $this->productModel->find($id);
        if (!$row) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON(['data' => $row]);
    }

    // CREATE
    public function store()
    {
        $post = $this->request->getPost();
        if (!$this->productModel->insert($post)) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'errors' => $this->productModel->errors(),
            ]);
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil tambah data'
        ]);
    }


    // UPDATE
    public function update($id)
    {
        $post = $this->request->getPost();
        if (!$this->productModel->update($id, $post)) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'errors' => $this->productModel->errors(),
            ]);
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Berhasil update data'
        ]);
    }


    // DELETE
    public function delete($id)
    {
        if ($this->productModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Produk berhasil dihapus'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal menghapus produk'
        ]);
    }
}
