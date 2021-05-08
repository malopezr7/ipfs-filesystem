<?php

namespace Mlopez\IPFS;

use Illuminate\Support\Facades\Facade;
use Mlopez\IPFS\Clients\IPFSClient;

/**
 *
 * @method static format_url(string $baseUrl)
 * @method id(array $queryParams = [])
 * @method cat(string $hash, array $queryParams = [])
 * @method add($data, $fileName = '', array $queryParams = [])
 * @method rm(string $arg, bool $force = false)
 * @method mv(string $source, string $dest)
 * @method mkdir($arg)
 * @method ls(string $hash, array $queryParams = [])
 * @method size(string $hash, array $queryParams = [])
 * @method stats(string $hash, array $queryParams = [])
 * @method pin(string $hash, array $queryParams = [])
 * @method unpin(string $hash, array $queryParams = [])
 *
 * @see \Mlopez\IPFS\Clients\IPFSClient
 */
class IPFS extends Facade
{
    protected static function getFacadeAccessor()
    {
        return IPFSClient::class;
    }
}
