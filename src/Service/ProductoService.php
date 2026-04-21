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
    public function findByName(string $productoName ){

        return  $this->repo->findByName($productoName);
    }

    public function summaryByCategory(){

        return  $this->repo->summaryByCategory();
    }
    public function findByDate(string $fechaInicio , string $fechaFin ){

        return  $this->repo->findByDate($fechaInicio, $fechaFin);
    }
}
