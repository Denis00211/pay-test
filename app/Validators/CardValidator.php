<?php

namespace App\Validators;

use Carbon\Carbon;
use Throwable;

class CardValidator
{
    private string $cardNumber;
    private string $cardMonth;
    private int $cardYear;

    public function __construct(string $cardNumber, string $cardMonth, int $cardYear)
    {
        $this->cardNumber = $cardNumber;
        $this->cardMonth = $cardMonth;
        $this->cardYear = $cardYear;
    }

    public function validate():bool
    {
        return $this->validateCard() && $this->validateDate();
    }

    private function validateCard(): bool
    {
        $cardNumber = $this->cardNumber;
        // оставить только цифры
        $s = strrev(preg_replace('/[^\d]/','',$cardNumber));

        // вычисление контрольной суммы
        $sum = 0;
        for ($i = 0, $j = strlen($s); $i < $j; $i++) {
            // использовать четные цифры как есть
            if (($i % 2) == 0) {
                $val = $s[$i];
            } else {
                // удвоить нечетные цифры и вычесть 9, если они больше 9
                $val = $s[$i] * 2;
                if ($val > 9)  $val -= 9;
            }
            $sum += $val;
        }

        // число корректно, если сумма равна 10
        return (($sum % 10) == 0);
    }

    private function validateDate(): bool
    {
        $now  = Carbon::now('UTC');
        try {
            $d = Carbon::createFromFormat('d-m-Y', '01-' . $this->cardMonth . '-' . $this->cardYear);
        } catch (Throwable $exception) {
            return false;
        }
        if(!$d || $d->format('m-Y') != $this->cardMonth . '-' . $this->cardYear){
            return false;
        }

        if($d->isBefore($now)) {
            return false;
        }

        return true;

    }
}
