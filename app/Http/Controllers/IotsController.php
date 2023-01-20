<?php

namespace App\Http\Controllers;

use App\Models\{IotData, ItemCatalogo};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Helpers\Constants;
use Toastr;
use Carbon\Carbon;

class IotsController extends Controller
{
    protected $dto;

    public function __construct()
    {
        $this->constants = new Constants();
    }

    public function index()
    {
        return view('iot.sensor.index');
    }

    public function data(Request $request)
    {
        $records = IotData::query()
            ->select('iot_data.id', 'iot_data.sensor_code', 'iot_data.tipo_dato_id', 'iot_data.value', 'iot_data.created_at', 'TIPO.nombre AS tipo_nombre')
            ->join('item_catalogo AS TIPO', 'iot_data.tipo_dato_id', '=', 'TIPO.id')
            ->orderBy('id', 'DESC')
            ->get();
        return Datatables()
            ->of($records)
            ->addColumn('chk', function ($row) {
                return '<input type="checkbox" class="i-checks" id="datos[]" name="datos[]" value="' . $row->id . '"> ';
            })
            ->editColumn('tipo_nombre', function ($row) {
                return ($row->tipo_nombre == 'Humedad') ? '<span class="label label-success">' . strtoupper($row->tipo_nombre) . '</span>' : '<span class="label label-info">' . strtoupper($row->tipo_nombre) . '</span>';
            })
            ->addColumn('fecha_registro', function ($row) {
                return (!empty($row->created_at) ? Carbon::parse($row->created_at)->isoFormat('DD MMM YYYY - H:mm:ss a') : '');
            })
            ->addColumn('opc', function ($row) {
                return '<span class="spacerMenu" data-toggle="tooltip" data-placement="top" title="' . trans('labels.eliminar') . '"><a href="#" data-href="' . route('iots.delete', $row) . '" data-toggle="modal" data-target="#modal-confirm-delete" data-placement="top" data-name="' . $row->nombre . '" class="btn btn-default"><i class="fa fa-trash"></i></a></span>';
            })
            ->rawColumns(['opc', 'tipo_dato', 'tipo_nombre', 'chk'])
            ->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ IotData  $iot
     * @return \Illuminate\Http\Response
     */
    public function destroy(IotData $iot)
    {
        try {
            $data = IotData::find($iot->id);
            if (isset($data)) {
                $data->delete();
                Toastr::success(trans('msg.msgEliminacionCorrecta'), trans('labels.sensores'), $this->constants->notificationDefaultOptions);
            } else
                Toastr::error(trans('msg.errProcesarInformacion'), trans('labels.sensores'), $this->constants->notificationDefaultOptions);

            return redirect()->route('iots.index');
        } catch (Exception $e) {
            Log::critical("Exception: " . $e);
            Toastr::error(trans('msg.errProcesarInformacion'), trans('labels.sensores'), $this->constants->notificationDefaultOptions);
            return redirect()->route('iots.index');
        }
    }

    public function deleteData(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'datos' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->route('iots.index')
                    ->withErrors($validator)
                    ->withInput();
            }

            $arrData = $request->datos;
            foreach ($arrData as $row) {
                $data = IotData::find($row);
                if (isset($data)) {
                    $data->delete();
                }
            }
            Toastr::success(trans('msg.msgActualizacionExitosa'), trans('labels.sensores'), $this->constants->notificationDefaultOptions);
            return redirect()->route('iots.index');
        } catch (Exception $ex) {
            Log::critical("Delete Data sensors Exception: " . $ex->getMessage() . '---' . $ex);
            Toastr::error(trans('msg.errProcesarInformacion') . ': ' . $ex->getMessage(), trans('labels.sensores'), $this->constants->notificationDefaultOptions);
            return redirect()->route('iots.index')->withInput();
        }
    }

    public function chart()
    {
        return view('iot.sensor.chart');
    }

    public function dataChart(Request $request)
    {
        $data = [];
        $typeId = (!empty($request->type) and ($request->type == 'T')) ? ItemCatalogo::getItemCatalogoIdByCatalogoCodeItemCode("TIPO_DATO_SENSOR", "T") : ItemCatalogo::getItemCatalogoIdByCatalogoCodeItemCode("TIPO_DATO_SENSOR", "H");
        $records = IotData::query()
            ->select('iot_data.id', 'iot_data.sensor_code', 'iot_data.tipo_dato_id', 'iot_data.value', 'iot_data.created_at', 'TIPO.nombre AS tipo_nombre')
            ->join('item_catalogo AS TIPO', 'iot_data.tipo_dato_id', '=', 'TIPO.id')
            ->where('iot_data.tipo_dato_id', $typeId)
            ->orderBy('id', 'DESC')
            ->take(500)
            ->get();
        $cont = 0;
        if (isset($records)) {
            foreach ($records as $row) {
                $data[$cont]['y'] = (!empty($row->created_at) ? Carbon::parse($row->created_at)->isoFormat('DD/MM/YY - H:mm:ss') : '');
                $data[$cont]['a'] = $row->value;
                $cont++;
            }
        }
        echo json_encode($data);
    }
}
