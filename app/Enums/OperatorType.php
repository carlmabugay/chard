<?php

namespace App\Enums;

enum OperatorType: string
{
    case EQ = '=';
    case LIKE = 'like';
    case GT = '>';
    case GTE = '>=';
    case LT = '<';
    case LTE = '<=';
    case IN = 'in';
    case BETWEEN = 'between';
}
