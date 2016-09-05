<?php

namespace Symfony\Cmf\Component\Description\Schema;

interface ExtensionInterface
{
    public function buildSchema(Builder $builder);
}
