<?php

namespace App\Helpers;

class Constants
{
    public $nameNotificationProcess = 'n0t1fiction@';

    // Datos Servicecontext
    public $servicecontextName = 'ServiceContext';
    public $contextSessionId = 'SessionId';
    public $contextFirstname = 'firstname';
    public $contextLastname = 'lastname';
    public $contextUsername = 'username';
    public $contextEmail  = 'email';
    public $contextToken = 'token';
    public $contextSitio = 'sitio';
    public $contextRol = 'rol';
    public $contextSitioId = 'sitioId';
    public $contextSitioSelector = 'sitioSelector';
    public $contextRolId = 'rolId';
    public $contextUserId = 'userId';
    public $contextSelector = 'selector';
    public $contextPersonId = 'personId';
    public $contextFechaAcceso = 'fecha_registro';
    public $contextFechaExpiracion = 'fecha_expira';
    public $contextAvatar = 'avatar';

    public $sessionUserShowTab = 'userShowTab';

    // Datos trabajo con sesiones
    public $sessionErrorLogin = 'ERROR_USER_ACCESS_LOGIN';
    public $sessionActiveMenu = "CURRENT_ACTIVE_MENU";
    public $sessionPendingTask = "USER_PENDING_TASKS";
    public $sessionActiveAlerts = "SITE_ACTIVE_ALERTS";
    public $sessionSummaryMails = "USER_SUMMARY_MAILS";

    // Parametros por defecto
    public $resourcePublicPath = "public";
    public $resourceStoragePath = "storage";
    public $resourcePathSites = "sites";
    public $resourcePathUser = "user";
    public $separatorSlug = "-";
    public $separatorCode = "_";

    // Local Paths
    // ecommerce
    public $baseEcommercePath = 'images/ecommerce/';
    public $baseStorageEcommercePath = 'storage/ecommerce/';

    // user
    public $baseUserPath = 'images/user/';
    public $baseStorageUserPath = 'storage/user/';

    // menu
    public $baseMenuPath = 'images/menu/';
    public $baseStorageMenuPath = 'storage/menu/';

    // sitios
    public $baseSitioPath = 'images/sites/';

    // Codigos Catalogos - Itemcatalogos
    public $codigoRecursoImagen = "IMAGEN";

    public $notificationDefaultOptions = [
        "positionClass" => "toast-top-center",
        "showDuration" => "5000",
        "closeButton" => true,
        "progressBar" => true,
    ];
}
