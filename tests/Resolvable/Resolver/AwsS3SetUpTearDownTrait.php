<?php

namespace Gaufrette\Extras\Tests\Resolvable\Resolver;

use Aws\S3\S3Client;

/**
 * @TODO: To be removed
 * @see https://github.com/KnpLabs/Gaufrette/pull/494
 */
trait AwsS3SetUpTearDownTrait
{
    /** @var string */
    private $bucket;

    /** @var S3Client */
    private $client;

    public function setUp()
    {
        $key    = getenv('AWS_KEY');
        $secret = getenv('AWS_SECRET');
        $region = getenv('AWS_REGION');

        if (empty($key) || empty($secret)) {
            $this->markTestSkipped('Missing AWS_KEY and/or AWS_SECRET env vars.');
        }

        $this->bucket = uniqid(getenv('AWS_BUCKET'));

        // For AWS SDK v2
        if (class_exists('Aws\Common\Client\AbstractClient')) {
            return $this->client = S3Client::factory([
                'region' => $region ? $region : 'eu-west-1',
                'version' => '2006-03-01',
                'key' => $key,
                'secret' => $secret,
            ]);
        }

        // For AWS SDK v3
        $this->client = new S3Client([
            'region'      => $region ? $region : 'eu-west-1',
            'version'     => 'latest',
            'credentials' => [
                'key'    => $key,
                'secret' => $secret,
            ],
        ]);
    }

    public function tearDown()
    {
        if ($this->client === null || !$this->client->doesBucketExist($this->bucket)) {
            return;
        }

        $result = $this->client->listObjects(['Bucket' => $this->bucket]);
        $staleObjects = $result->get('Contents');

        foreach ($staleObjects as $staleObject) {
            $this->client->deleteObject(['Bucket' => $this->bucket, 'Key' => $staleObject['Key']]);
        }

        $this->client->deleteBucket(['Bucket' => $this->bucket]);
    }
}
