<?php
declare(strict_types=1);

namespace Src\Framework\Database\Query;

use Src\Framework\Database\ExpressionInterface;

use function Src\Framework\Database\express;

class DeleteQuery extends AbstractQuery
{
    use Capability\HasFrom;
    use Capability\HasWhere;
    use Capability\HasLimit;

    public function asExpression(): ExpressionInterface
    {
        $query = $this->startExpression();
        $query = $this->applyFrom($query);
        $query = $this->applyWhere($query);
        $query = $this->applyLimit($query);

        return $query;
    }

    protected function startExpression(): ExpressionInterface
    {
        return express('DELETE');
    }
}
