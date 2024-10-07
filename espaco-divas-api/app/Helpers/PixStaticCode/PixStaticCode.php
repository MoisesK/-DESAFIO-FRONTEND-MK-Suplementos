<?php

namespace App\Helpers\PixStaticCode;


use SimpleSoftwareIO\QrCode\Facades\QrCode;
final class PixStaticCode
{
    public function __construct(
        private string $pix,
        private readonly PixKeyType $keyType,
        private string $receiverName = '',
        private readonly float $amount = 0,
        private string $city = 'Sao Paulo',
    ) {
        $this->receiverName = substr(trim($this->removeAccents($this->receiverName)), 0, 25);
        $this->city = trim($this->removeAccents($this->city));

        if ($keyType->value === PixKeyType::PHONE->value) {
            $this->pix = preg_replace('/[^0-9a-zA-Z]/', '', $this->pix);
            $this->pix = '+55' . $this->pix;
        }
    }

    public function getStaticKey(): string
    {
        $child = $this->mountString(PixEmvCode::GLOBALLY_UNIQUE_IDENTIFIER, 'br.gov.bcb.pix')
            . $this->mountString(PixEmvCode::PIX_KEY, $this->pix);

        $merchantAccountInfo = $this->mountString(PixEmvCode::MERCHANT_ACCOUNT_INFORMATION, $child);

        $child = $this->mountString(PixEmvCode::TX_ID, '***');
        $additionalDataFieldTemplate = $this->mountString(PixEmvCode::ADDITIONAL_DATA_FIELD_TEMPLATE, $child);

        $amount = $this->amount > 0
            ? $this->mountString(PixEmvCode::TRANSACTION_AMOUNT, number_format($this->amount, 2, '.', ''))
            : '';

        $receiverName = !empty($this->receiverName)
            ? $this->mountString(PixEmvCode::MERCHANT_NAME, $this->receiverName)
            : '';

        $string = '000201' .
            $merchantAccountInfo .
            $this->mountString(PixEmvCode::MERCHANT_CATEGORY_CODE, '0000') .
            $this->mountString(PixEmvCode::TRANSACTION_CURRENCY, '986') .
            $amount .
            $this->mountString(PixEmvCode::COUNTRY_CODE, 'BR') .
            $receiverName .
            $this->mountString(PixEmvCode::MERCHANT_CITY, $this->city) .
            $additionalDataFieldTemplate;

        return $string . $this->mountString(
                PixEmvCode::CRC16,
                $this->crcChecksum($string . substr($this->mountString(PixEmvCode::CRC16, 'xxxx'), 0, 4))
            );
    }

    public function getQrCode(): string
    {
        return QrCode::size(600)->generate($this->getStaticKey());
    }

    private function mountString(PixEmvCode $emvCode, string $value): string
    {
        return "{$emvCode->value}"
            . str_pad((string)strlen($value), 2, '0', STR_PAD_LEFT)
            . trim($value);
    }

    private function crcChecksum($str): string
    {
        $charCodeAt = fn ($str, $i) => ord(substr($str, $i, 1));

        $crc = 0xFFFF;
        $strlen = strlen($str);
        for ($c = 0; $c < $strlen; $c++) {
            $crc ^= $charCodeAt($str, $c) << 8;
            for ($i = 0; $i < 8; $i++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ 0x1021;
                } else {
                    $crc = $crc << 1;
                }
            }
        }
        $hex = $crc & 0xFFFF;
        $hex = dechex($hex);
        $hex = strtoupper($hex);

        return str_pad($hex, 4, '0', STR_PAD_LEFT);
    }

    private function removeAccents(string $text): string
    {
        $search = explode(",", "à,á,â,ä,æ,ã,å,ā,ç,ć,č,è,é,ê,ë,ē,ė,ę,î,ï,í,ī,į,ì,ł,ñ,ń,ô,ö,ò,ó,œ,ø,ō,õ,ß,ś,š,û,ü,ù,ú,ū,ÿ,ž,ź,ż,À,Á,Â,Ä,Æ,Ã,Å,Ā,Ç,Ć,Č,È,É,Ê,Ë,Ē,Ė,Ę,Î,Ï,Í,Ī,Į,Ì,Ł,Ñ,Ń,Ô,Ö,Ò,Ó,Œ,Ø,Ō,Õ,Ś,Š,Û,Ü,Ù,Ú,Ū,Ÿ,Ž,Ź,Ż"); // phpcs:ignore
        $replace = explode(",", "a,a,a,a,a,a,a,a,c,c,c,e,e,e,e,e,e,e,i,i,i,i,i,i,l,n,n,o,o,o,o,o,o,o,o,s,s,s,u,u,u,u,u,y,z,z,z,A,A,A,A,A,A,A,A,C,C,C,E,E,E,E,E,E,E,I,I,I,I,I,I,L,N,N,O,O,O,O,O,O,O,O,S,S,U,U,U,U,U,Y,Z,Z,Z"); // phpcs:ignore
        return str_replace($search, $replace, $text);
    }
}
