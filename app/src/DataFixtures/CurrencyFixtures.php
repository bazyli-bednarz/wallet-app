<?php
/**
 * Currency fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CategoryFixtures.
 */
class CurrencyFixtures extends AbstractBaseFixtures
{
    private array $data = ['PLN', 'USD', 'EUR', 'CHF', 'ALL', 'AFN', 'ARS', 'AWG', 'AUD', 'AZN', 'BSD', 'BBD', 'BYR', 'BZD', 'BMD',
            'BOB', 'BAM', 'BWP', 'BGN', 'BRL', 'BND', 'KHR', 'CAD', 'KYD', 'CLP', 'CNY', 'COP', 'CRC', 'HRK', 'CUP',
            'CZK', 'DKK', 'DOP', 'EGP', 'SVC', 'EEK', 'FKP', 'FJD', 'GEL', 'GHC', 'GIP', 'GTQ', 'GGP', 'GYD', 'HNL',
            'HKD', 'HUF', 'ISK', 'INR', 'IDR', 'IRR', 'IMP', 'ILS', 'JMD', 'JPY', 'JEP', 'KZT', 'KPW', 'KRW', 'KGS',
            'LAK', 'LVL', 'LBP', 'LRD', 'LTL', 'MKD', 'MYR', 'MUR', 'MXN', 'MNT', 'MZN', 'NAD', 'NPR', 'ANG', 'NZD',
            'NIO', 'NGN', 'NOK', 'OMR', 'PKR', 'PAB', 'PYG', 'PEN', 'PHP', 'QAR', 'RON', 'RUB', 'SHP', 'SAR', 'RSD',
            'SCR', 'SGD', 'SBD', 'SOS', 'ZAR', 'LKR', 'SEK', 'SRD', 'SYP', 'TWD', 'THB', 'TTD', 'TRL', 'TVD', 'UAH',
            'GBP', 'UYU', 'UZS', 'VEF', 'VND', 'YER', 'ZWD', ];

    /**
     * Load data.
     *
     * @param ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
//        $data = ['PLN', 'USD', 'EUR', 'CHF', 'ALL', 'AFN', 'ARS', 'AWG', 'AUD', 'AZN', 'BSD', 'BBD', 'BYR', 'BZD', 'BMD',
//            'BOB', 'BAM', 'BWP', 'BGN', 'BRL', 'BND', 'KHR', 'CAD', 'KYD', 'CLP', 'CNY', 'COP', 'CRC', 'HRK', 'CUP',
//            'CZK', 'DKK', 'DOP', 'EGP', 'SVC', 'EEK', 'FKP', 'FJD', 'GEL', 'GHC', 'GIP', 'GTQ', 'GGP', 'GYD', 'HNL',
//            'HKD', 'HUF', 'ISK', 'INR', 'IDR', 'IRR', 'IMP', 'ILS', 'JMD', 'JPY', 'JEP', 'KZT', 'KPW', 'KRW', 'KGS',
//            'LAK', 'LVL', 'LBP', 'LRD', 'LTL', 'MKD', 'MYR', 'MUR', 'MXN', 'MNT', 'MZN', 'NAD', 'NPR', 'ANG', 'NZD',
//            'NIO', 'NGN', 'NOK', 'OMR', 'PKR', 'PAB', 'PYG', 'PEN', 'PHP', 'QAR', 'RON', 'RUB', 'SHP', 'SAR', 'RSD',
//            'SCR', 'SGD', 'SBD', 'SOS', 'ZAR', 'LKR', 'SEK', 'SRD', 'SYP', 'TWD', 'THB', 'TTD', 'TRL', 'TVD', 'UAH',
//            'GBP', 'UYU', 'UZS', 'VEF', 'VND', 'YER', 'ZWD', ];

        $this->createMany(112, 'currencies', function ($i){
            $currency = new Currency();
            $currency->setName($this->data[$i]);

            return $currency;
        });

//        for ($i = 0; $i < 111; ++$i) {
//            $currency = new Currency();
//            $currency->setName($data[$i]);
//        }
        $manager->flush();
    }
}
