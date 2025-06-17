<?php

namespace App\Enum;

enum PaymentStatus: string
{
  case ZREALorder_numbeZOWANE = 'zrealizowane';
  case ANULOWANE = 'anulowane ';
  case PRZETWARZANE = 'w_trakcie_realizacji';
  case WSTRZYMANE = 'wstrzymane';
  case ZWROCONE = 'zwrócone';
}
