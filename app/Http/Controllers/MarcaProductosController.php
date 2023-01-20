<?php

namespace App\Http\Controllers;

use App\Models\MarcaProducto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Helpers\Constants;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Libraries\AuthUtil;
use App\Libraries\Util;
use App\Libraries\UtilEcommerce;
use URL;
use Toastr;

class MarcaProductosController extends Controller
{
    protected $dto;

    public function __construct()
    {
        $this->constants = new Constants();
    }

    public function index()
    {
        return view('ecommerce.marca-productos.index');
    }

    public function data(Request $request)
    {
        $records = MarcaProducto::getMarcaProductos();
        return Datatables()
            ->of($records)
            ->addColumn('opc', function ($row) {
                return '<span class="spacerMenu" data-toggle="tooltip" data-placement="top" title="' . trans('labels.ver') . '"><a href="' . route('marcaProductos.show', $row) . '" class="btn btn-default"><i class="fa fa-eye"></i></a></span> '; //$this->getActionColumn($row);
            })
            ->rawColumns(['opc'])
            ->toJson();
    }

    protected function getActionColumn($row)
    {
        $imageEstado = "fa fa-times";
        $tooltipActivo = trans('labels.inactivo');
        if ($row->enabled) {
            $tooltipActivo = trans('labels.activo');
            $imageEstado = "fa fa-check";
        }

        //$options = '<span class="spacerMenu" data-toggle="tooltip" data-placement="top" title="' . trans('labels.ver') . '"><a href="' . route('marcaProductos.show', $row) . '" class="btn btn-default"><i class="fa fa-eye"></i></a></span> ';
        $options = '<span class="spacerMenu" data-toggle="tooltip" data-placement="top" title="' . $tooltipActivo . '"><a href="' . route('marcaProductos.enabled', $row) . '" class="btn btn-default"><i class="' . $imageEstado . '"></i></a></span> ';
        $options .= '<span class="spacerMenu" data-toggle="tooltip" data-placement="top" title="' . trans('labels.editar') . '"><a href="' . route('marcaProductos.edit', $row) . '" class="btn btn-default"><i class="fa fa-pencil"></i></a></span> ';
        $options .= '<span class="spacerMenu" data-toggle="tooltip" data-placement="top" title="' . trans('labels.eliminar') . '"><a href="#" data-href="' . route('marcaProductos.delete', $row) . '" data-toggle="modal" data-target="#modal-confirm-delete" data-placement="top" data-name="' . $row->nombre . '" class="btn btn-default"><i class="fa fa-trash"></i></a></span>';
        return $options;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ecommerce.marca-productos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $authUtil = new AuthUtil();
        $constants = new Constants();
        $utilEcommerce = new UtilEcommerce();
        try {

            $validator = Validator::make($request->all(), [
                'Nombre' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->route('marcaProductos.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            $marcaProducto = new MarcaProducto();
            $marcaProducto->sitio_id = $authUtil->getServiceContextValue($constants->contextSitioId);
            $marcaProducto->nombre = $request->Nombre;
            $marcaProducto->resumen = $request->Resumen;
            $marcaProducto->slug = Str::slug($request->Nombre, $constants->separatorSlug);
            $marcaProducto->orden = 1;
            $marcaProducto->total_productos = 0;
            $marcaProducto->enabled = true;
            $marcaProducto->selector = $this->generateSelector();
            if ($request->file('Imagen')) {
                $basepath = $utilEcommerce->getCurrentBaseEcommercePath() . 'brand/';

                $fileName = Str::random(15) . '.' . $request->file('Imagen')->extension();
                $request->Imagen->move(public_path($basepath), $fileName);
                if (file_exists(public_path($basepath) . $fileName)) {
                    $urlFile = URL::to('/') . '/' . $utilEcommerce->getCurrentBaseEcommercePath() . 'brand/' . $fileName;
                    //$urlFile = '/' . $utilEcommerce->getCurrentBaseEcommercePath() . 'brand/' . $fileName;
                    $marcaProducto->imagen = $fileName;
                    $marcaProducto->url_imagen = $urlFile;
                }
            }
            $marcaProducto->save();
            Toastr::success(trans('msg.msgRegistroExitoso'), trans('ecommerce.marcaProductos'), $this->constants->notificationDefaultOptions);
            return redirect()->route('marcaProductos.index');
        } catch (Exception $ex) {
            Log::critical("Insert MarcaProducto Exception: " . $ex->getMessage() . '---' . $ex);
            Toastr::error(trans('msg.errProcesarInformacion') . ': ' . $ex->getMessage(), trans('ecommerce.marcaProductos'), $this->constants->notificationDefaultOptions);
            return redirect()->route('marcaProductos.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ MarcaProducto  $marcaProducto
     * @return \Illuminate\Http\Response
     */
    public function show(MarcaProducto $marcaProducto)
    {
        return view('ecommerce.marca-productos.show')->with('marcaProducto', $marcaProducto);
        //return redirect()->route('marcaProductos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ MarcaProducto  $marcaProducto
     * @return \Illuminate\Http\Response
     */
    public function edit(MarcaProducto $marcaProducto)
    {
        return view('ecommerce.marca-productos.edit')->with('marcaProducto', $marcaProducto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ MarcaProducto  $marcaProducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MarcaProducto $marcaProducto)
    {
        $utilEcommerce = new UtilEcommerce();
        try {

            $validator = Validator::make($request->all(), [
                'Nombre' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->route('marcaProductos.edit', $marcaProducto)
                    ->withErrors($validator)
                    ->withInput();
            }
            $marcaProducto->nombre = $request->Nombre;
            $marcaProducto->resumen = $request->Resumen;
            if ($request->file('Imagen')) {
                $basepath = $utilEcommerce->getCurrentBaseEcommercePath() . 'brand/';

                $fileName = Str::random(15) . '.' . $request->file('Imagen')->extension();
                $request->Imagen->move(public_path($basepath), $fileName);
                if (file_exists(public_path($basepath) . $fileName)) {
                    // Elimina el archivo anterior
                    if (!empty($marcaProducto->imagen) && file_exists(public_path($basepath) . $marcaProducto->imagen))
                        File::delete(public_path($basepath) . $marcaProducto->imagen);

                    // Configura los nuevos datos
                    $urlFile = URL::to('/') . '/' . $utilEcommerce->getCurrentBaseEcommercePath() . 'brand/' . $fileName;
                    //$urlFile = '/' . $utilEcommerce->getCurrentBaseEcommercePath() . 'brand/' . $fileName;
                    $marcaProducto->imagen = $fileName;
                    $marcaProducto->url_imagen = $urlFile;
                }
            }
            $marcaProducto->save();
            Toastr::success(trans('msg.msgActualizacionExitosa'), trans('ecommerce.marcaProductos'), $this->constants->notificationDefaultOptions);
            return redirect()->route('marcaProductos.index');
        } catch (Exception $ex) {
            Log::critical("Update Exception: " . $ex->getMessage() . '---' . $ex);
            Toastr::error(trans('msg.errProcesarInformacion') . ': ' . $ex->getMessage(), trans('ecommerce.marcaProductos'), $this->constants->notificationDefaultOptions);
            return redirect()->route('marcaProductos.edit', $marcaProducto)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ MarcaProducto  $marcaProducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarcaProducto $marcaProducto)
    {
        $utilEcommerce = new UtilEcommerce();
        try {
            $data = MarcaProducto::getMarcaProductoById($marcaProducto->id);
            if (isset($data)) {
                $basePath = $utilEcommerce->getCurrentBaseEcommercePath() . 'brand/';

                if (file_exists(public_path($basePath) . $data->imagen)) {
                    // Verifica y elimina si existe la imagen anterior
                    if (!empty($data->imagen) && file_exists(public_path($basePath) . $data->imagen))
                        File::delete(public_path($basePath) . $data->imagen);
                }
                $data->delete();
                Toastr::success(trans('msg.msgEliminacionCorrecta'), trans('ecommerce.marcaProductos'), $this->constants->notificationDefaultOptions);
            } else
                Toastr::error(trans('msg.errProcesarInformacion'), trans('ecommerce.marcaProductos'), $this->constants->notificationDefaultOptions);

            return redirect()->route('marcaProductos.index');
        } catch (Exception $e) {
            Log::critical("Exception: " . $e);
            Toastr::error(trans('msg.errProcesarInformacion'), trans('ecommerce.marcaProductos'), $this->constants->notificationDefaultOptions);
            return redirect()->route('marcaProductos.index');
        }
    }

    /**
     * Enable/disable a record
     * @param  \App\Models\ MarcaProducto  $marcaProducto
     */
    public function enabled(MarcaProducto $marcaProducto)
    {
        try {
            $data = MarcaProducto::find($marcaProducto->id);
            $data->enabled = !$marcaProducto->enabled;
            $data->save();
            Toastr::success(trans('msg.msgActualizacionExitosa'), trans('ecommerce.marcaProductos'), $this->constants->notificationDefaultOptions);
            return redirect()->route('marcaProductos.index');
        } catch (Exception $e) {
            Log::critical("Exception: " . $e);
            Toastr::error(trans('msg.errProcesarInformacion'), trans('ecommerce.marcaProductos'), $this->constants->notificationDefaultOptions);
            return redirect()->route('marcaProductos.index');
        }
    }

    protected function generateSelector()
    {
        $response = '';
        $util = new Util();
        $time = now()->timestamp;
        $selector = $util->GetSelector(25);
        $data = MarcaProducto::select('id')->where('selector', $selector)->first();
        $response = (!isset($data)) ? $selector : $selector . $time;
        return $response;
    }
}
