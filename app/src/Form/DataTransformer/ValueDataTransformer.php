<?php
/**
 * wallet-app.
 *
 * (c) Bazyli Bednarz, 2021
 */

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Value data transformer.
 *
 * Class ValueDataTransformer
 */
class ValueDataTransformer implements DataTransformerInterface
{
    /**
     * Generate float from integer value.
     *
     * @param mixed $value
     *
     * @return float
     */
    public function transform($value): float
    {
        return intval($value) / 100;
    }

    /**
     * Generate integer value from inputted float.
     *
     * @param mixed $value
     *
     * @return int
     */
    public function reverseTransform($value): int
    {
        $modified = str_replace(',', '.', $value);
        $modified = str_replace(' ', '', $modified);
        $regex = '/^[-]?([0-9])+(\.)?([0-9])*$/';

        if (!preg_match($regex, $modified)) {
            return 0;
        }

        return intval(strval($modified) * 100);
    }
}
