<?php
namespace App\Service;

use App\Repository\ProductoRepository;


class ProductoService {

    private ProductoRepository $repo;


    public function __construct(ProductoRepository $repo)
    {
        $this->repo = $repo;
    }

    public function buscarPorCategoria(string $categoria ): array{

        return $this->repo->findBy(['categoria' => $categoria]);

    }
}
