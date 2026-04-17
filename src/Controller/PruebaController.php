<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductoRepository;
use App\Repository\LoteRepository;
use App\Service\TrazabilidadService;
use App\Service\ProductoService;
use Symfony\Component\HttpFoundation\JsonResponse;


class PruebaController extends AbstractController {

    #[Route('/prueba/{categoria}' ,name:'BuscarPorCategoria')]
    public function buscarPorCategoria(string $categoria , ProductoService $service){

        $resultados = $service->buscarPorCategoria($categoria);
        return $this->json($resultados);

    }

    #[Route('/prueba/resumen/{productoId}' ,name:'getResumen')]
    public function getResumen(int $productoId , TrazabilidadService  $service){

        $resultados = $service->getResumen($productoId);
        return $this->json($resultados);

    }
    #[Route('/buscar/{productoName}' ,name:'findByName')]
    public function findByName(string $productoName , ProductoRepository  $repository){

        $resultados = $repository->findByName($productoName);
        return $this->json($resultados);

    }

    #[Route('/productos/stock' ,name:'findProductsWithStock')]
    public function findProductsWithStock(LoteRepository  $repository){

        $resultados = $repository->findProductsWithStock();
        return $this->json($resultados);

    }
}
