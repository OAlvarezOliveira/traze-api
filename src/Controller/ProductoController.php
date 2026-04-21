<?php

namespace App\Controller;

use App\Service\ProductoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductoController extends AbstractController {
    #[Route('/api/consultas/categoria/{categoria}', name: 'findByCategory')]
    public function buscarPorCategoria(string $categoria , ProductoService $service){

        $resultados = $service->buscarPorCategoria($categoria);
        return $this->json($resultados);

    }

#[Route('/api/consultas/buscar/{productoName}', name: 'findByName')]
    public function findByName(string $productoName , ProductoService $service){

    $resultados = $service->findByName($productoName);
    return $this->json($resultados);

}

    #[Route('/api/consultas/resumen-categoria', name: 'summaryByCategory')]
    public function summaryByCategory(ProductoService $service){

    $resultados = $service->summaryByCategory();
    return $this->json($resultados);

}
    #[Route('/api/consultas/por-fechas/{fechaInicio}/{fechaFin}', name: 'findByDate')]
    public function findByDate(string $fechaInicio , string $fechaFin ,ProductoService $service){

    $resultados = $service->findByDate($fechaInicio, $fechaFin);
    return $this->json($resultados);

}
}
