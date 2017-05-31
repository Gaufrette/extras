<?php

namespace Gaufrette\Extras\Resolvable\Resolver;

use Aws\S3\S3Client;
use Gaufrette\Extras\Resolvable\ResolverInterface;

/**
 * Resolves objects' path into public URLs.
 */
class AwsS3PublicUrlResolver implements ResolverInterface
{
    /** @var S3Client */
    private $service;

    /** @var string */
    private $bucket;

    /** @var string */
    private $baseDir;

    /**
     * @param S3Client $service
     * @param string   $bucket  Bucket used by the adapter
     * @param string   $baseDir Base directory used by the adapter, if any
     */
    public function __construct(S3Client $service, $bucket, $baseDir = '')
    {
        $this->service = $service;
        $this->bucket  = $bucket;
        $this->baseDir = trim($baseDir, '/');
    }

    /**
     * Resolves given object $path into public URL.
     *
     * @param string $path
     *
     * @return string
     */
    public function resolve($path)
    {
        return $this->service->getObjectUrl(
            $this->bucket,
            ltrim($this->baseDir . '/' . ltrim($path, '/'), '/')
        );
    }
}
