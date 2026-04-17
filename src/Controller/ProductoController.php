<?php

namespace App\Controller;

use App\Service\ProductoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductoRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductoController extends AbstractController {
    #[Route('/api/consultas/categoria/{categoria}', name: 'findByCategory')]
    public function buscarPorCategoria(string $categoria , ProductoService $service){

        $resultados = $service->buscarPorCategoria($categoria);
        return $this->json($resultados);

    }
    #[Route('/api/consultas/buscar/{productoName}', name: 'findByName')]
    public function findByName(string $productoName , ProductoRepository  $repository){

        $resultados = $repository->findByName($productoName);
        return $this->json($resultados);

    }

    #[Route('/api/consultas/resumen-categoria', name: 'summaryByCategory')]
    public function summaryByCategory(ProductoRepository  $repository){

        $resultados = $repository->summaryByCategory();
        return $this->json($resultados);

    }
    #[Route('/api/consultas/por-fechas/{fechaInicio}/{fechaFin}', name: 'findByDate')]
    public function findByDate(string $fechaInicio , string $fechaFin ,ProductoRepository  $repository){

        $resultados = $repository->findByDate($fechaInicio, $fechaFin);
        return $this->json($resultados);

    }
}
