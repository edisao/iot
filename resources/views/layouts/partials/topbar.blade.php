<?php 
    use App\Libraries\AuthUtil;
    use App\Models\RolFuncionalidad;
    use App\Models\Funcionalidad;
    use App\Helpers\Constants;

    $authUtil = new AuthUtil();
    $constants = new Constants();

    $usuarioNombres = $authUtil->getServiceContextValue($constants->contextFirstname);
    $usuarioApellidos = $authUtil->getServiceContextValue($constants->contextLastname);
    $sitio = $authUtil->getServiceContextValue($constants->contextSitio);

    $totalAlerts = 0;
    $labelTotalAlerts = '';
    if (session()->has($constants->sessionActiveAlerts)) {
        $activeAlerts = session()->get($constants->sessionActiveAlerts);
        
        $totalAlerts = count($activeAlerts);
        if($totalAlerts > 0)
            $labelTotalAlerts = '<span class="label label-primary">'.$totalAlerts.'</span>';
    }

    $totalMails = 0;
    $labelTotalMails = '';
    if (session()->has($constants->sessionSummaryMails)) {
        $summaryMails = session()->get($constants->sessionSummaryMails);
        
        $totalMails = count($summaryMails);
        if($totalMails > 0)
            $labelTotalMails = '<span class="label label-primary">'.$totalMails.'</span>';
    }
?>
<div class="row border-bottom">
    <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">
                    {{ trans('labels.bienvenido') }} <strong>{{ $usuarioNombres  . ' ' . $usuarioApellidos }}</strong> - <strong>{{ $sitio }}</strong>
                </span>
            </li>
            
            <li>
                <a href="{{ route('logout') }}">
                    <i class="fa fa-sign-out"></i> {{ trans('labels.salirSistema') }}
                </a>
            </li>
            
        </ul>

    </nav>
</div>