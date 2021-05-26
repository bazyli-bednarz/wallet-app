<?php
/**
 * Currency repository.
 */

namespace App\Repository;

/**
 * Class CurrencyRepository.
 */
class CurrencyRepository
{
    /**
     * Data.
     *
     * @var array static array with data
     */
    private array $data = [
        1 => ['id' => 1, 'name' => 'PLN'],
        ['id' => 2, 'name' => 'USD'],
        ['id' => 3, 'name' => 'EUR'],
        ['id' => 4, 'name' => 'CHF'],
        ['id' => 5, 'name' => 'ALL'],
        ['id' => 6, 'name' => 'AFN'],
        ['id' => 7, 'name' => 'ARS'],
        ['id' => 8, 'name' => 'AWG'],
        ['id' => 9, 'name' => 'AUD'],
        ['id' => 10, 'name' => 'AZN'],
        ['id' => 11, 'name' => 'BSD'],
        ['id' => 12, 'name' => 'BBD'],
        ['id' => 13, 'name' => 'BYR'],
        ['id' => 14, 'name' => 'BZD'],
        ['id' => 15, 'name' => 'BMD'],
        ['id' => 16, 'name' => 'BOB'],
        ['id' => 17, 'name' => 'BAM'],
        ['id' => 18, 'name' => 'BWP'],
        ['id' => 19, 'name' => 'BGN'],
        ['id' => 20, 'name' => 'BRL'],
        ['id' => 21, 'name' => 'BND'],
        ['id' => 22, 'name' => 'KHR'],
        ['id' => 23, 'name' => 'CAD'],
        ['id' => 24, 'name' => 'KYD'],
        ['id' => 25, 'name' => 'CLP'],
        ['id' => 26, 'name' => 'CNY'],
        ['id' => 27, 'name' => 'COP'],
        ['id' => 28, 'name' => 'CRC'],
        ['id' => 29, 'name' => 'HRK'],
        ['id' => 30, 'name' => 'CUP'],
        ['id' => 31, 'name' => 'CZK'],
        ['id' => 32, 'name' => 'DKK'],
        ['id' => 33, 'name' => 'DOP'],
        ['id' => 34, 'name' => 'EGP'],
        ['id' => 35, 'name' => 'SVC'],
        ['id' => 36, 'name' => 'EEK'],
        ['id' => 37, 'name' => 'FKP'],
        ['id' => 38, 'name' => 'FJD'],
        ['id' => 39, 'name' => 'GEL'],
        ['id' => 40, 'name' => 'GHC'],
        ['id' => 41, 'name' => 'GIP'],
        ['id' => 42, 'name' => 'GTQ'],
        ['id' => 43, 'name' => 'GGP'],
        ['id' => 44, 'name' => 'GYD'],
        ['id' => 45, 'name' => 'HNL'],
        ['id' => 46, 'name' => 'HKD'],
        ['id' => 47, 'name' => 'HUF'],
        ['id' => 48, 'name' => 'ISK'],
        ['id' => 49, 'name' => 'INR'],
        ['id' => 50, 'name' => 'IDR'],
        ['id' => 51, 'name' => 'IRR'],
        ['id' => 52, 'name' => 'IMP'],
        ['id' => 53, 'name' => 'ILS'],
        ['id' => 54, 'name' => 'JMD'],
        ['id' => 55, 'name' => 'JPY'],
        ['id' => 56, 'name' => 'JEP'],
        ['id' => 57, 'name' => 'KZT'],
        ['id' => 58, 'name' => 'KPW'],
        ['id' => 59, 'name' => 'KRW'],
        ['id' => 60, 'name' => 'KGS'],
        ['id' => 61, 'name' => 'LAK'],
        ['id' => 62, 'name' => 'LVL'],
        ['id' => 63, 'name' => 'LBP'],
        ['id' => 64, 'name' => 'LRD'],
        ['id' => 65, 'name' => 'LTL'],
        ['id' => 66, 'name' => 'MKD'],
        ['id' => 67, 'name' => 'MYR'],
        ['id' => 68, 'name' => 'MUR'],
        ['id' => 69, 'name' => 'MXN'],
        ['id' => 70, 'name' => 'MNT'],
        ['id' => 71, 'name' => 'MZN'],
        ['id' => 72, 'name' => 'NAD'],
        ['id' => 73, 'name' => 'NPR'],
        ['id' => 74, 'name' => 'ANG'],
        ['id' => 75, 'name' => 'NZD'],
        ['id' => 76, 'name' => 'NIO'],
        ['id' => 77, 'name' => 'NGN'],
        ['id' => 78, 'name' => 'NOK'],
        ['id' => 79, 'name' => 'OMR'],
        ['id' => 80, 'name' => 'PKR'],
        ['id' => 81, 'name' => 'PAB'],
        ['id' => 82, 'name' => 'PYG'],
        ['id' => 83, 'name' => 'PEN'],
        ['id' => 84, 'name' => 'PHP'],
        ['id' => 85, 'name' => 'QAR'],
        ['id' => 86, 'name' => 'RON'],
        ['id' => 87, 'name' => 'RUB'],
        ['id' => 88, 'name' => 'SHP'],
        ['id' => 89, 'name' => 'SAR'],
        ['id' => 90, 'name' => 'RSD'],
        ['id' => 91, 'name' => 'SCR'],
        ['id' => 92, 'name' => 'SGD'],
        ['id' => 93, 'name' => 'SBD'],
        ['id' => 94, 'name' => 'SOS'],
        ['id' => 95, 'name' => 'ZAR'],
        ['id' => 96, 'name' => 'LKR'],
        ['id' => 97, 'name' => 'SEK'],
        ['id' => 98, 'name' => 'SRD'],
        ['id' => 99, 'name' => 'SYP'],
        ['id' => 100, 'name' => 'TWD'],
        ['id' => 101, 'name' => 'THB'],
        ['id' => 102, 'name' => 'TTD'],
        ['id' => 103, 'name' => 'TRL'],
        ['id' => 104, 'name' => 'TVD'],
        ['id' => 105, 'name' => 'UAH'],
        ['id' => 106, 'name' => 'GBP'],
        ['id' => 107, 'name' => 'UYU'],
        ['id' => 108, 'name' => 'UZS'],
        ['id' => 109, 'name' => 'VEF'],
        ['id' => 110, 'name' => 'VND'],
        ['id' => 111, 'name' => 'YER'],
        ['id' => 112, 'name' => 'ZWD'],
    ];

    /**
     * Returns all currencies stored in database.
     *
     * @return array|array[] Result
     */
    public function findAll(): array
    {
        return $this->data;
    }

    /**
     * Returns a single currency identified by its ID.
     *
     * @param int $id Currency ID
     *
     * @return array Result
     */
    public function findById(int $id): ?array
    {
        return isset($this->data[$id]) && count($this->data) ? $this->data[$id] : null;
    }
}
