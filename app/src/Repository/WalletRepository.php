<?php
/**
 * Wallet repository.
 */

namespace App\Repository;

/**
 * Class WalletRepository.
 */
class WalletRepository
{
    /**
     * Data.
     *
     * @var array static array with data
     */
    private array $data = [
        1 => [
            'id' => 1,
            'name' => 'Wallet 1',
            'currency' => 'USD',
            'balance' => 123000.12,
            'operations' => [
                [
                    'id' => 1,
                    'name' => 'Rent money',
                    'time' => '2010-09-02 11:11:11',
                    'value' => 1002.00,
                    'category' => 'Job',
                    'tags' => [
                        'small_income',
                        'free',
                        'dummy',
                    ],
                ],
                [
                    'id' => 2,
                    'name' => 'Job money',
                    'time' => '2011-11-03 12:21:13',
                    'value' => 11232.11,
                    'category' => 'Job',
                    'tags' => [
                    ],
                ],
                [
                    'id' => 3,
                    'name' => 'Stolen money',
                    'time' => '2011-11-03 12:21:13',
                    'value' => 112222.23,
                    'category' => 'Job',
                    'tags' => [
                        'stolen',
                    ],
                ],
            ],
        ],
        2 => [
            'id' => 2,
            'name' => 'Wallet 2',
            'currency' => 'PLN',
            'balance' => 100.00,
            'operations' => [
                [
                    'id' => 1,
                    'name' => 'Stock income',
                    'time' => '2010-09-02 11:11:11',
                    'value' => 1012.02,
                    'category' => 'Stock',
                    'tags' => [
                        'small_income',
                        'stock',
                    ],
                ],
                [
                    'id' => 2,
                    'name' => 'From granny',
                    'time' => '2011-11-03 12:21:13',
                    'value' => 110.11,
                    'category' => 'Job',
                    'tags' => [
                        'granny',
                        'free',
                    ],
                ],
                [
                    'id' => 3,
                    'name' => 'Groceries',
                    'time' => '2011-11-03 12:21:13',
                    'value' => -222.00,
                    'category' => 'Expenses',
                    'tags' => [
                        'shopping',
                    ],
                ],
            ],
        ],
        3 => [
            'id' => 3,
            'name' => 'Wallet 3',
            'currency' => 'CHF',
            'balance' => 1235.95,
            'operations' => [
                [
                    'id' => 1,
                    'name' => 'Tax fraud',
                    'time' => '2010-09-02 11:11:11',
                    'value' => 100000.11,
                    'category' => 'Other',
                    'tags' => [
                        'stolen',
                    ],
                ],
                [
                    'id' => 2,
                    'name' => 'Chess.com membership',
                    'time' => '2011-11-03 12:21:13',
                    'value' => -11232.04,
                    'category' => 'Expenses',
                    'tags' => [
                        'chess',
                        'subscription',
                    ],
                ],
                [
                    'id' => 3,
                    'name' => 'Stolen money',
                    'time' => '2011-11-03 12:21:13',
                    'value' => 112222.10,
                    'category' => 'Job',
                    'tags' => [
                        'small_income',
                        'stolen',
                    ],
                ],
            ],
        ],
    ];

    /**
     * Returns all wallets stored in database.
     *
     * @return array|array[] Result
     */
    public function findAll(): array
    {
        return $this->data;
    }

    /**
     * Returns a single wallet identified by its ID.
     *
     * @param int $id Wallet ID
     *
     * @return array Result
     */
    public function findById(int $id): ?array
    {
        return isset($this->data[$id]) && count($this->data) ? $this->data[$id] : null;
    }
}
