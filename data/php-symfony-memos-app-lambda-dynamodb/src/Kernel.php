<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @return list<string> An array of allowed values for APP_ENV
     */
    private function getAllowedEnvs(): array
    {
        return ['prod', 'dev', 'test'];
    }

    public function getCacheDir(): string
    {
        if (getenv('AWS_LAMBDA_RUNTIME_API')) {
            return \sprintf('/tmp/symfony-cache/%s', $this->environment);
        }

        return parent::getCacheDir();
    }
}
