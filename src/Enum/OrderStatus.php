<?php

namespace App\Enum;

enum OrderStatus: string
{
  case ZREALIZOWANE = 'zrealizowane';
  case ANULOWANE = 'anulowane ';
  case PRZETWARZANE = 'W trakcie ralizacji';
  case WSTRZYMANE = 'Wstrzymane';
  case ZWROCONE = 'zwrócone';
}
