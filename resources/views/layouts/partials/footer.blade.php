<?php 
    use App\Libraries\AuthUtil;
    use App\Helpers\Constants;
    $authUtil = new AuthUtil();
    $constants = new Constants();
    $sitio = $authUtil->getSitioInfoById($authUtil->getServiceContextValue($constants->contextSitioId));
?>
<div class="footer">
    <div class="float-right">
        {{ trans('labels.version') }} <strong>{{ $sitio->version }}</strong>.
    </div>
    <div>
        <strong>{{ $sitio->mensaje_copyright }}</strong>
    </div>
</div>