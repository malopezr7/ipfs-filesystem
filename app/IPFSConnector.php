<?php

namespace App;


use Illuminate\Support\Facades\Http;

class IPFSConnector
{

    /**
     * The API rest endpoint url for IPFS.
     * @var string
     */
    private string $baseUrl;

    /**
     * The API rest endpoint url formatted for IPFS.
     * @var string
     */
    private string $baseUri;

    /**
     * The api port
     * @var int
     */
    private int $port;

    /**
     * The current version of the API to use.
     */
    private string $version = 'v0';

    /**
     * IPFSClient constructor.
     *
     * @param string $baseUrl
     * @param int $port
     * @param int $timeout
     * @param bool $debug
     */
    public function __construct()
    {
        $this->baseUrl = env('IPFS_BASE_URL');
        $this->port = env('IPFS_PORT');
        $this->baseUri = self::format_url("$this->baseUrl:$this->port/api/$this->version/");
    }


    private function format_url(string $baseUrl)
    {
        return rtrim($baseUrl, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public function rootHash()
    {
        return json_decode(Http::post($this->baseUri . 'stat?arg=/')->body())->hash;
    }


    /**
     * Obtenemos el contenido del fichero
     * @param string $hash
     * @param array $queryParams
     * @return \Illuminate\Http\Client\Response
     */
    public function cat(string $hash, array $queryParams = [])
    {
        return Http::post($this->baseUri . "cat/$hash", $queryParams);
    }

    /**
     * Subimos el fichero, posteriormente es necesario moverlo a la raiz para poder almacenarlo en carpetas.
     * @param $file
     * @param $path
     * @return mixed
     * @throws \Exception
     */
    public function upload($file, $path)
    {
        $add = Http::attach(
            'data', $file->get(), $file->getClientOriginalName()
        )->post($this->baseUri . 'add');

        if ($add->status() != 200)
            throw new \Exception('Error al subir: ' . $add->body());

        $hash = json_decode($add->body())->Hash;
        /**
         * peticion post feísima poniendo los parametros a mano, pero necesitaba poner los dos parametros con el mismo nombre y no podia meterlos en un array
         */
        $cp = Http::post($this->baseUri . 'files/cp?arg=/ipfs/' . $hash . '&arg=/' . $path);

        if (str_contains($cp->body(), 'directory already has entry by that name'))
            throw new \Exception('El fichero ya existe en el directorio');

        return $hash;
    }

    /**
     * Crea carpeta y retorna su hash
     * @param $arg
     * @return mixed
     * @throws \Exception
     */
    public function mkdir($arg)
    {
        $queryParams = [
            'arg' => '/' . $arg,
        ];
        $save = Http::post($this->baseUri . "files/mkdir" . $this->format_query_params($queryParams));
        if ($save->status() != 200)
            throw new \Exception('ha ocurrido un error al crear la carpeta: ' . $save->body());
        $stat = Http::post($this->baseUri . "files/stat" . $this->format_query_params($queryParams));
        if ($stat->status() != 200)
            throw new \Exception('Error al crear carpeta: ' . $stat->body());

        $hash = json_decode($stat->body())->Hash;

        return $hash;
    }

    /**
     * Eliminamos cualquier elemento, de forma recursiva por si fuera carpeta
     * @param $arg
     * @return bool
     */
    public function rm($arg)
    {
        $queryParams = [
            'recursive' => true,
            'arg' => '/' . $arg,
        ];
        $rm = Http::post($this->baseUri . "files/rm" . $this->format_query_params($queryParams));
        return $rm->status() == 200;
    }


    /**
     * cargo la info del elemento en ipfs para retornar el tamaño
     * @param $element
     * @return mixed
     * @throws \Exception
     */
    public function loadSize($element)
    {
        $queryParams = [
            'arg' => '/' . $element->full_url()
        ];
        $stat = Http::post($this->baseUri . 'files/stat' . $this->format_query_params($queryParams));

        if ($stat->status() != 200)
            throw new \Exception('Error al obtener la informacion del elemento: ' . $stat->body());

        return json_decode($stat->body())->CumulativeSize;
    }

    /**
     * @param $queryParams
     * @return string
     */
    public function format_query_params($queryParams)
    {
        $str = '?';
        foreach ($queryParams as $key => $param) {
            $str .= $key . '=' . $param;
            if (next($queryParams)) {
                $str .= '&';
            }
        }
        return $str;
    }

}