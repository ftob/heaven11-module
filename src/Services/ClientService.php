<?php
namespace Heaven11\Client\Services;


use AdIntelligence\Client\Repositories\Contracts\RepositoryInterface;
use AdIntelligence\Client\Services\Contracts\RequesterInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use Heaven11\Client\Exceptions\HeavenServerException;
use Illuminate\Contracts\Filesystem\Filesystem;
use PHPUnit\Runner\Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class ClientService
 * @package AdIntelligence\Client\Services
 */
class ClientService
{

    /** @var ClientInterface  */
    protected $client;

    /** @var  UriInterface */
    protected $uri;

    /**
     * ClientService constructor.
     * @param ClientInterface $client
     * @param UriInterface $uri
     * @internal param $endpoint
     * @internal param Filesystem $storage
     * @internal param RepositoryInterface $repository
     */
    public function __construct(ClientInterface $client, UriInterface $uri)
    {
        $this->client = $client;
        $this->uri = $uri;
    }

    /**
     * @return mixed
     * @throws HeavenServerException
     */
    public function get()
    {
        $response = $this->client->request('GET', $this->uri);

        if ($response->getStatusCode() == 200) {
            return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
        } else {
            throw new HeavenServerException();
        }
    }
}