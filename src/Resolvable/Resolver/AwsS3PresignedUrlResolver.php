<?php

namespace Gaufrette\Extras\Resolvable\Resolver;

use Aws\S3\S3Client;
use Gaufrette\Extras\Resolvable\ResolverInterface;

/**
 * Resolves object paths into time-limited URLs, namely presigned URLs.
 *
 * @author Albin Kerouanton <albin.kerouanton@knplabs.com>
 *
 * @see http://docs.aws.amazon.com/AmazonS3/latest/dev/ShareObjectPreSignedURL.html
 */
class AwsS3PresignedUrlResolver implements ResolverInterface
{
    /** @var S3Client */
    private $service;

    /** @var string */
    private $bucket;

    /** @var string */
    private $baseDir;

    /** @var \DateTimeInterface */
    private $expiresAt;

    /**
     * @param S3Client           $service   Could be the same as the one given to the adapter or any other S3 client.
     * @param string             $bucket    Same as the one given to adapter.
     * @param string             $baseDir   Same as the one given to adapter.
     * @param \DateTimeInterface $expiresAt Presigned links are valid for a certain amount time of time only.
     */
    public function __construct(S3Client $service, $bucket, $baseDir, \DateTimeInterface $expiresAt)
    {
        $this->service   = $service;
        $this->bucket    = $bucket;
        $this->baseDir   = trim($baseDir, '/');
        $this->expiresAt = $expiresAt;
    }

    /**
     * Resolves given object path into presigned request URI.
     *
     * @param string $path
     *
     * @return string
     */
    public function resolve($path)
    {
        // For AWS SDK v2
        if ($this->service instanceof \Aws\Common\Client\AbstractClient) {
            return $this->service->getObjectUrl(
                $this->bucket,
                $this->computePath($path),
                $this->expiresAt
            );
        }

        // For AWS SDK v3
        $command = $this->service->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key'    => $this->computePath($path),
        ]);

        return (string) $this->service->createPresignedRequest($command, $this->expiresAt)->getUri();
    }

    /**
     * Appends baseDir to $key.
     *
     * @param string $key
     *
     * @return string
     */
    private function computePath($key)
    {
        return ltrim($this->baseDir . '/' . ltrim($key, '/'), '/');
    }
}
