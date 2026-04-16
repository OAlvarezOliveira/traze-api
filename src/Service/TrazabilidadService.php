<?php

namespace App\Service;
use App\Repository\MovimientoRepository;
use App\Repository\LoteRepository;
use App\Repository\ProductoRepository;




class TrazabilidadService
{
private int $productoId;
private MovimientoRepository $mov;
private LoteRepository $lote;

    public function __construct(MovimientoRepository $mov , LoteRepository $lote , ProductoRepository $repo)
    {
        $this->mov = $mov;
        $this->lote = $lote;
        $this->repo = $repo;
    }


    public function getResumen(int $productoId): array
    {
        $numerosLote  = [];
        $producto = $this->repo->find($productoId);
        if(!$producto ){
            throw new \Exception("Producto no encontrado");
        }
        $lotes = $this->lote->findBy(['producto' => $productoId]);
        $totalLotes = count($lotes);
        $totalMovimientos = 0;

        foreach ($lotes as $lote) {
            $totalMovimientos += count($lote->getMovimientos());
            $numerosLote [] = $lote->getNumeroLote();

        }

        return [
            'producto_id' => $productoId,
            'total_lotes' => $totalLotes,
            'total_movimientos' => $totalMovimientos,
            'lotes' => $numerosLote];

    }
}
