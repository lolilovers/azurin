<?php
declare(strict_types=1);

namespace Src\Framework\Database\Engine;

class CommonEngine extends BasicEngine
{
    public function escapeIdentifier(string $identifier): string
    {
        return "\"$identifier\"";
    }
}
