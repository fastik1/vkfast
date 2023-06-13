<?php

namespace Fastik1\Vkfast\Interfaces;

interface RuleInterface
{
    public function passes($event): bool;
}