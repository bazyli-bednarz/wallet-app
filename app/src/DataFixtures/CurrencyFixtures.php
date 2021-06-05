<?php
/**
 * Currency fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CategoryFixtures.
 */
class CurrencyFixtures extends Fixture
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Object manager
     */
    public function load(ObjectManager $manager): void
    {
        $data = ['PLN', 'USD', 'EUR', 'CHF', 'ALL', 'AFN', 'ARS', 'AWG', 'AUD', 'AZN', 'BSD', 'BBD', 'BYR', 'BZD', 'BMD',
            'BOB', 'BAM', 'BWP', 'BGN', 'BRL', 'BND', 'KHR', 'CAD', 'KYD', 'CLP', 'CNY', 'COP', 'CRC', 'HRK', 'CUP',
            'CZK', 'DKK', 'DOP', 'EGP', 'SVC', 'EEK', 'FKP', 'FJD', 'GEL', 'GHC', 'GIP', 'GTQ', 'GGP', 'GYD', 'HNL',
            'HKD', 'HUF', 'ISK', 'INR', 'IDR', 'IRR', 'IMP', 'ILS', 'JMD', 'JPY', 'JEP', 'KZT', 'KPW', 'KRW', 'KGS',
            'LAK', 'LVL', 'LBP', 'LRD', 'LTL', 'MKD', 'MYR', 'MUR', 'MXN', 'MNT', 'MZN', 'NAD', 'NPR', 'ANG', 'NZD',
            'NIO', 'NGN', 'NOK', 'OMR', 'PKR', 'PAB', 'PYG', 'PEN', 'PHP', 'QAR', 'RON', 'RUB', 'SHP', 'SAR', 'RSD',
            'SCR', 'SGD', 'SBD', 'SOS', 'ZAR', 'LKR', 'SEK', 'SRD', 'SYP', 'TWD', 'THB', 'TTD', 'TRL', 'TVD', 'UAH',
            'GBP', 'UYU', 'UZS', 'VEF', 'VND', 'YER', 'ZWD', ];

        for ($i = 0; $i < 111; ++$i) {
            $currency = new Currency();
            $currency->setName($data[$i]);
            $manager->persist($currency);
        }

//        $this->createMany(112, 'currencies', function ($i) {
//            $currency = new Currency();
//            $currency->setName($data[$i++]);
//
//            return $currency;
//        });

        $manager->flush();
    }
}
