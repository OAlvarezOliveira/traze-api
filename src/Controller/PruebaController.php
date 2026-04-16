<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductoRepository;
use App\Service\ProductoService;
use Symfony\Component\HttpFoundation\JsonResponse;


class PruebaController extends AbstractController {

    #[Route('/prueba' ,name:'prueba')]

    public function index(){

     return $this->json(['msg'=>'Hola symfony']);
    }


    #[Route('/prueba/saludo/{nombre}' ,name:'saludo')]
    public function saludar($nombre){

        return new Response("Hola $nombre");

    }

    #[Route('/prueba/{categoria}' ,name:'BuscarPorCategoria')]
    public function buscarPorCategoria(string $categoria , ProductoService $service){

        $resultados = $service->buscarPorCategoria($categoria);
        return $this->json($resultados);

    }
}
