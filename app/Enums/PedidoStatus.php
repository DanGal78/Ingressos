<?php

namespace App\Enums;

enum PedidoStatus{
    case PENDENTE;
    case EM_PROCESSAMENTO;
    case RECUSADO;
    case CANCELADO;
    case PAGO;


    public static function getName(PedidoStatus $status): string
    {
        return match($status){
            PedidoStatus::PENDENTE => 'PENDENTE',
            PedidoStatus::EM_PROCESSAMENTO => 'EM PROCESSAMENTO',
            PedidoStatus::RECUSADO => 'RECUSADO',
            PedidoStatus::CANCELADO => 'CANCELADO',
            PedidoStatus::PAGO => 'PAGO',
        };
    }
}
