<?php

namespace App\Enum;

enum OrderStatus: string
{
    case ZREALIZOWANE = 'zrealizowane';
    case ANULOWANE = 'anulowane ';
    case PRZETWARZANE = 'w_trakcie_realizacji';
      case WSTRZYMANE = 'wstrzymane';
        case ZWROCONE = 'zwrócone';
}