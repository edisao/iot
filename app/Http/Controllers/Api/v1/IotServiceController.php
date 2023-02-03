<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\{IotData, ItemCatalogo};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\ApiController;

use App\Helpers\Constants;
use Exception;

class IotServiceController extends ApiController
{
    protected $constants;

    public function __construct()
    {
        $this->constants = new Constants();
    }

    public function sensor(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'trama' => 'required'
            ]);
            if ($validator->fails()) {
                Log::critical("Error storing sensor data: TRAMA");
                return $this->errorResponse(trans('api.errBadRequest'), 400, json_encode($validator->errors()));
            }

            //Log::debug("TRAMA: " . $request->trama);

            // S:SENSOR001;T:18;H:20
            $requestDataSensor = explode(";", $request->trama);
            // [0] -> S:SENSOR001
            // [1] -> T:18
            // [2] -> H:20

            // Obtiene el codigo del sensor que registra la data
            $codeSensor = explode(":", $requestDataSensor[0]);

            // Obtiene el dato de la temperatura
            $tempData = explode(":", $requestDataSensor[1]);

            // Obtiene el dato de la humedad
            $humedadData = explode(":", $requestDataSensor[2]);

            $idItemTemperatura = ItemCatalogo::getItemCatalogoIdByCatalogoCodeItemCode("TIPO_DATO_SENSOR", "T");
            $idItemHumedad = ItemCatalogo::getItemCatalogoIdByCatalogoCodeItemCode("TIPO_DATO_SENSOR", "H");

            if ($this->is_decimal($tempData[1]) && $tempData[1] > 0) {
                // Temperatura
                $objData = new IotData();
                $objData->sensor_code = $codeSensor[1];
                $objData->tipo_dato_id = $idItemTemperatura;
                $objData->value = $tempData[1];
                $objData->save();
            } else
                Log::critical("Temperatura: Data error: " . $tempData[1] . ". Full: trama: " . $request->trama);

            /*
            if ($this->is_decimal($humedadData[1]) && $humedadData[1] > 0) {
                // Humedad
                $objDataH = new IotData();
                $objDataH->sensor_code = $codeSensor[1];
                $objDataH->tipo_dato_id = $idItemHumedad;
                $objDataH->value = $humedadData[1];
                $objDataH->save();
            } else
                Log::critical("Humedad: Data error: " . $humedadData[1] . ". Full: trama: " . $request->trama);

            */

            return $this->successResponse("", "OK");
        } catch (Exception $ex) {
            Log::critical("Exception storing sensor data: " . $ex->getMessage() . '---' . $ex);
            return $this->errorResponse(trans('api.errInternalServerError'), 500, null);
        }
    }

    function is_decimal($val)
    {
        return is_numeric($val);
    }
}
