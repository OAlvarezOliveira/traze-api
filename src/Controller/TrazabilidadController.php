<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LoteRepository;
use App\Service\TrazabilidadService;
use Symfony\Component\HttpFoundation\JsonResponse;


class TrazabilidadController extends AbstractController {

    #[Route('/api/consultas/trazabilidad/{productoId}', name: 'getResumen')]
    public function getResumen(int $productoId , TrazabilidadService  $service){

        $resultados = $service->getResumen($productoId);
        return $this->json($resultados);

    }

    #[Route('/api/consultas/con-stock', name: 'findProductsWithStock')]
    public function findProductsWithStock(LoteRepository  $repository){

        $resultados = $repository->findProductsWithStock();
        return $this->json($resultados);

    }
}
