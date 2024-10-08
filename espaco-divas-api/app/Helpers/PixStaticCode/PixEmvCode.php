<?php

namespace App\Helpers\PixStaticCode;

enum PixEmvCode: string
{
    case MERCHANT_ACCOUNT_INFORMATION = '26';
    case GLOBALLY_UNIQUE_IDENTIFIER = '00';
    case PIX_KEY = '01';
    case MERCHANT_CATEGORY_CODE = '52';
    case TRANSACTION_CURRENCY = '53';
    case TRANSACTION_AMOUNT = '54';
    case COUNTRY_CODE = '58';
    case MERCHANT_NAME = '59';
    case MERCHANT_CITY = '60';
    case ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
    case TX_ID = '05';
    case CRC16 = '63';
}
