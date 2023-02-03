<?php

namespace App\Libraries;

use App\Helpers\Constants;
use App\Models\{Sitio};
use App\Models\{Producto, ProductoRecurso};
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use URL;
use App\Libraries\AuthUtil;
use File;

class UtilEcommerce
{
    protected $constants;

    public function __construct()
    {
        $this->constants = new Constants();
    }

    function getUrlBackgroungImageProduct($productId)
    {
        $url = "";
        //$producto = Producto::query()->select('nombre', 'sitio_id', 'selector')->where('id', $productId)->first();
        $imagen =  ProductoRecurso::query()
            ->select('producto_recurso.archivo', 'producto_recurso.url', 'item_catalogo.codigo AS tipo_codigo')
            ->join('item_catalogo', 'producto_recurso.tipo_id', '=', 'item_catalogo.id')
            ->where('producto_id', $productId)
            ->where('item_catalogo.codigo', 'BACKGROUND')
            ->first();

        if (isset($imagen)) {
            //$url = URL::to('/') . '/' . $this->getBaseEcommercePathBySiteId($producto->sitio_id) . 'product/' . $producto->selector . '/' . $file;
            if ($this->checkRemoteFile($imagen->url))
                return $imagen->url;
            else
                return null;
        } else
            return null;
    }

    function getUrlIconImageProduct($productId)
    {
        $url = "";
        //$producto = Producto::query()->select('nombre', 'sitio_id', 'selector')->where('id', $productId)->first();
        $imagen =  ProductoRecurso::query()
            ->select('producto_recurso.archivo', 'producto_recurso.url', 'item_catalogo.codigo AS tipo_codigo')
            ->join('item_catalogo', 'producto_recurso.tipo_id', '=', 'item_catalogo.id')
            ->where('producto_recurso.producto_id', $productId)
            ->where('item_catalogo.codigo', 'ICONO')
            ->first();

        if (isset($imagen)) {
            //$url = URL::to('/') . '/' . $this->getBaseEcommercePathBySiteId($producto->sitio_id) . 'product/' . $producto->selector . '/' . $file;
            if ($this->checkRemoteFile($imagen->url))
                return $imagen->url;
            else
                return null;
        } else
            return null;
    }

    function getUrlImageProduct($productId, $file)
    {
        $url = "";
        $defaultProductImage = Config::get('ecommerce.images.defaul_image_product_name');
        $producto = Producto::query()->select('nombre', 'sitio_id', 'selector')->where('id', $productId)->first();
        $url = URL::to('/') . '/' . $this->getBaseEcommercePathBySiteId($producto->sitio_id) . 'product/' . $producto->selector . '/' . $file;
        if ($this->checkRemoteFile($url))
            return $url;
        else {
            Log::warning("No existe imagen del producto: Id: " . $productId . "\n" . 'Producto: ' . $producto->nombre . "\nUrl: " . $url);
            return URL::to('/') . '/images/ecommerce/' . $defaultProductImage;
        }
    }

    // Path del ecommerce
    function getBaseEcommercePathBySiteId($siteId)
    {
        $constants = new Constants();
        $contenidoPath = '';
        $sitio = Sitio::query()->select('selector')->where('id', $siteId)->first();
        $contenidoPath = $constants->baseEcommercePath . $sitio->selector . '/';
        File::ensureDirectoryExists($contenidoPath);
        return $contenidoPath;
    }

    // Path del ecommerce
    function getCurrentBaseEcommercePath()
    {
        $authUtil = new AuthUtil();
        $constants = new Constants();
        $contenidoPath = '';
        $sitioSelector = $authUtil->getServiceContextValue($constants->contextSitioSelector);
        $contenidoPath = $constants->baseEcommercePath . $sitioSelector . '/';
        File::ensureDirectoryExists($contenidoPath);
        return $contenidoPath;
    }

    function checkRemoteFile($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        if ($result !== FALSE)
            return true;
        else
            return false;
    }
}
