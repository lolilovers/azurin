<?php

/**
 * ===========================
 * Output
 * ===========================
 */

namespace Src\Framework\Services;

class Output
{
    public function json($data = [])
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}