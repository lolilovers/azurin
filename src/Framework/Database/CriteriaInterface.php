<?php
declare(strict_types=1);

namespace Src\Framework\Database;

interface CriteriaInterface extends StatementInterface
{
    public function and(CriteriaInterface $right): CriteriaInterface;

    public function or(CriteriaInterface $right): CriteriaInterface;
}
