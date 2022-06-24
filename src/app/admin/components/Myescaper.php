<?php

namespace Multiple\Admin\Components;

use Phalcon\Escaper;

/**
 * Myescaper applies html escape to the passed values and then returns the obtained result
 */
class Myescaper
{
    public function sanitize($value) {
        $escaper = new Escaper();
        return $escaper->escapeHtml($value);
    }
}