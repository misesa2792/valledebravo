<?php
namespace App\Helpers;

class FunctionHelper
{
    //15-08-2025: Convierte decimales o numeros a enteros dejando siempre 2 decimales
    //Ejemplo: 4,500.346 = 450034
    public static function parseMoneyToBigInt($value)
    {
        $value = trim((string) $value);
        $value = preg_replace('/(?!^-)[^\d.]/', '', $value);

        if (strpos($value, '.') !== false) {
            list($ent, $dec) = explode('.', $value, 2);
            $dec = substr(preg_replace('/\D/', '', $dec), 0, 2); // solo dígitos, máx 2
            $dec = str_pad($dec, 2, '0');                        // 1 decimal -> 2
        } else {
            $ent = preg_replace('/\D/', '', $value);
            $dec = '00';
        }

        // Maneja signo
        $ent = preg_replace('/[^\d]/', '', $ent);
        return ($ent . $dec);
    }
    public static function centsBigIntToMoney($cents)
    {
        // Asegura tipo string para bcdiv y valores grandes
        $cents = (string) $cents;
        // Divide por 100 con 2 decimales exactos
        $amount = bcdiv($cents, '100', 2); 
        return $amount;
    }

    // 29-07-2025: Función para limpiar y normalizar una cadena numérica,
    // conservando únicamente dos decimales sin redondear.
    // Ejemplo: "4,56d7.678" → 4567.67
    public static function normalizeAmount($amount)
    {
        // Elimina todos los caracteres que no sean dígitos o punto decimal
        $clean = preg_replace('/(?!^-)[^\d.]/', '', $amount);

        // Convierte el resultado limpio a tipo float (número decimal)
        $float = floatval($clean);
        // Trunca a 2 decimales SIN redondear (ej: 10.129 → 10.12)
        $monto = floor($float * 100) / 100;
        // Devuelve el monto listo para validarse y guardarse
        return $monto;
    }
    //Da formato numérico a un monto con separadores de miles y decimales definidos.
    public static function numberFormat($amount, $number = 2)
    {
        return number_format($amount, $number);
    }
    //Muy útil cuando no necesariamente se necesitan los decimales, ejemplo en el PbRM-01c no puede aplicar decimales obligatorios, excepto tesorería
    public static function replaceDobleCeros($value)
    {
        $clean = preg_replace('/\.00$/', '', $value);
        return $clean;
    }
}