<?php

use Google\Service\AdExchangeBuyerII\HtmlContent;

session_start();
require "vendor/autoload.php";

use eftec\bladeone\BladeOne;
use Google\Service\Oauth2;
use Google\Service\Transcoder\Input;
use phpseclib3\Common\Functions\Strings;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

$provincias = [
    "15" => "A CORUÑA",
    "3" => "ALACANT",
    "2" => "ALBACETE",
    "4" => "ALMERIA",
    "33" => "ASTURIAS",
    "5" => "AVILA",
    "6" => "BADAJOZ",
    "8" => "BARCELONA",
    "9" => "BURGOS",
    "10" => "CACERES",
    "11" => "CADIZ",
    "39" => "CANTABRIA",
    "12" => "CASTELLO",
    "51" => "CEUTA",
    "13" => "CIUDAD REAL",
    "14" => "CORDOBA",
    "16" => "CUENCA",
    "17" => "GIRONA",
    "18" => "GRANADA",
    "19" => "GUADALAJARA",
    "21" => "HUELVA",
    "22" => "HUESCA",
    "7" => "ILLES BALEARS",
    "23" => "JAEN",
    "26" => "LA RIOJA",
    "35" => "LAS PALMAS",
    "24" => "LEON",
    "25" => "LLEIDA",
    "27" => "LUGO",
    "28" => "MADRID",
    "29" => "MALAGA",
    "52" => "MELILLA",
    "30" => "MURCIA",
    "32" => "OURENSE",
    "34" => "PALENCIA",
    "36" => "PONTEVEDRA",
    "38" => "S.C. TENERIFE",
    "37" => "SALAMANCA",
    "40" => "SEGOVIA",
    "41" => "SEVILLA",
    "42" => "SORIA",
    "43" => "TARRAGONA",
    "44" => "TERUEL",
    "45" => "TOLEDO",
    "46" => "VALENCIA",
    "47" => "VALLADOLID",
    "49" => "ZAMORA",
    "50" => "ZARAGOZA"
];


if (empty($_POST) && empty($_GET)) {

    $gClient = new Google_Client();
    $gClient->setAuthConfig("credentials.json");
    $gClient->addScope(Oauth2::USERINFO_PROFILE);

    $gClient->setRedirectUri('http://localhost:8000/');

    $authUrl = $gClient->createAuthUrl();
    echo $blade->run('login', ['authUrl' => $authUrl]);
} else if (filter_input(INPUT_GET, "code")) {
    echo $blade->run('form');
} else if (filter_input(INPUT_POST, "buscarMunicipio")) {

    $provinciaCod = filter_input(INPUT_POST, "provinciaSeleccionada");
    $provincia = $provincias[$provinciaCod];

    try {
        $url = "http://ovc.catastro.meh.es/ovcservweb/OVCSWLocalizacionRC/OVCCallejero.asmx?WSDL";

        $client = new SoapClient($url);
        $response = $client->ObtenerMunicipios($provincia)->any;

        // Decodificar la respuesta SOAP en formato JSON
        $xmlObject = simplexml_load_string($response);
        $json = json_decode(json_encode($xmlObject));

        $municipiosArray = [];

        foreach ($json->municipiero->muni as $municipio) {
            $nombreMunicipio = (string) $municipio->nm;
            $municipiosArray[] = $nombreMunicipio;
        }

        $ajax = $municipiosArray;
    } catch (SoapFault $e) {
        // echo "Error SOAP: " . $e->getMessage();
        $ajax = [];
    } catch (Exception $e) {
        // echo "Error: " . $e->getMessage();
        $ajax = [];
    }
    echo json_encode($ajax);
} else if (filter_input(INPUT_POST, "buscarVia")) {

    $provinciaCod = filter_input(INPUT_POST, "provinciaSeleccionada");
    $provincia = $provincias[$provinciaCod];
    $municipio = filter_input(INPUT_POST, "municipioSeleccionado");
    $tipoVia = filter_input(INPUT_POST, "tipoDeViaSeleccionada");

    try {
        $url = "http://ovc.catastro.meh.es/ovcservweb/OVCSWLocalizacionRC/OVCCallejero.asmx?WSDL";
        $client = new SoapClient($url);

        $response = $client->ObtenerCallejero($provincia, $municipio, $tipoVia)->any;

        // Decodificar la respuesta SOAP en formato JSON
        $xmlObject = simplexml_load_string($response);
        $json = json_decode(json_encode($xmlObject));

        $callesArray = [];

        if (isset($json->control->cuerr)){
            $calles = [];
            $callesArray = ["err" => (int) $json->lerr->err->cod];
        }else if ((int) $json->control->cuca == 1) {
            $calles = [$json->callejero->calle];
        } else {
            $calles = $json->callejero->calle;
        }

        foreach ($calles as $calle) {
            $nombreCalle = (string) $calle->dir->nv;
            $callesArray[] = $nombreCalle;
        }

        $ajax =  $callesArray;
    } catch (SoapFault $e) {
        // echo "Error SOAP: " . $e->getMessage();
        $ajax = [];
    } catch (Exception $e) {
        // echo "Error: " . $e->getMessage();
        $ajax = [];
    }

    echo json_encode($ajax);


} else if (filter_input(INPUT_POST, "consultarFinca")) {
    $provinciaCod = filter_input(INPUT_POST, "provincia");
    $provincia = $provincias[$provinciaCod];
    $municipio = filter_input(INPUT_POST, "municipio");
    $tipoVia = filter_input(INPUT_POST, "tipoDeVia");
    $via = filter_input(INPUT_POST, "via");
    $numero = filter_input(INPUT_POST, "numero");
    if (!$numero) $numero = "0";

    try {
        $url = "http://ovc.catastro.meh.es/ovcservweb/OVCSWLocalizacionRC/OVCCallejero.asmx?WSDL";
        $client = new SoapClient($url);
        $response = $client->ObtenerNumerero($provincia, $municipio, $tipoVia, $via, $numero)->any;

        // Decodificar la respuesta SOAP en formato JSON
        $xmlObject = simplexml_load_string($response);
        $json = json_decode(json_encode($xmlObject));

        $hojasArray = [];

        if (isset($json->control->cuerr) && (int) $json->lerr->err->cod != 43){
            $hojas = [];
            $hojasArray = ["err" => (int) $json->lerr->err->cod];
        }else if (isset($json->control->cuerr) && (int) $json->lerr->err->cod == 43 && !isset($json->control->cunum) ) {
            $hojas = [];
        }else if ((int) $json->control->cunum == 1) {
            $hojas = [$json->numerero->nump];
        } else {
            $hojas = $json->numerero->nump;
        }

        foreach ($hojas as $hoja) {
            $pc1 = (string) $hoja->pc->pc1;
            $pc2 = (string) $hoja->pc->pc2;
            $pnp = (string) $hoja->num->pnp;
            $plp = null;
            if (isset($hoja->num->plp) && is_string($hoja->num->plp)) {
                $plp = $hoja->num->plp;
            }

            $hojaArray = [
                "pc1" => $pc1,
                "pc2" => $pc2,
                "pnp" => $pnp,
                "plp" => $plp,
            ];

            $hojasArray[] = $hojaArray;
        }
        $ajax = $hojasArray;
    } catch (SoapFault $e) {
        // echo "Error SOAP: " . $e->getMessage();
        $ajax = [];
    } catch (Exception $e) {
        // echo "Error: " . $e->getMessage();
        $ajax = [];
    }

    echo json_encode($ajax);

} else if (filter_input(INPUT_POST, "consultarHojaDelCatastro")) {
    $provinciaCod = filter_input(INPUT_POST, "provincia");
    $provincia = $provincias[$provinciaCod];
    $municipio = filter_input(INPUT_POST, "municipio");
    $referenciaCatastral = filter_input(INPUT_POST, "referenciaCatastral");
    $numero = filter_input(INPUT_POST, "numero");

    try {
        $url = "http://ovc.catastro.meh.es/ovcservweb/OVCSWLocalizacionRC/OVCCallejero.asmx?WSDL";
        $client = new SoapClient($url);
        $response = $client->Consulta_DNPRC($provincia, $municipio, $referenciaCatastral)->any;

        // Decodificar la respuesta SOAP en formato JSON
        $xmlObject = simplexml_load_string($response);
        $json = json_decode(json_encode($xmlObject));

        $inmueblesArray = [];


        if ((int) $json->control->cudnp == 1) {
            $inmuebles = [$json->bico->bi];
        } else {
            $inmuebles = $json->lrcdnp->rcdnp;
        }


        foreach ($inmuebles as $inmueble) {
            if ((int) $json->control->cudnp == 1) {
                $rc = $inmueble->idbi->rc;
                $lourb = $inmueble->dt->locs->lous->lourb;
            } else {
                $rc = $inmueble->rc;
                $lourb = $inmueble->dt->locs->lous->lourb;
            }

            $pnp = (string) $lourb->dir->pnp;

            if ($pnp == $numero) {
                $nv = (string) $lourb->dir->nv;
                $es = isset($lourb->loint->es) ? (string) $lourb->loint->es : null;
                $pt = isset($lourb->loint->pt) ? (string) $lourb->loint->pt : null;
                $pu = isset($lourb->loint->pu) ? (string) $lourb->loint->pu : null;

                $pc1 = (string) $rc->pc1;
                $pc2 = (string) $rc->pc2;
                $car = (string) $rc->car;
                $cc1 = (string) $rc->cc1;
                $cc2 = (string) $rc->cc2;

                $inmuebleArray["pnp"] = $pnp;
                $inmuebleArray["nv"] = $nv;
                $inmuebleArray["es"] = $es;
                $inmuebleArray["pt"] = $pt;
                $inmuebleArray["pu"] = $pu;

                $inmuebleArray["pc1"] = $pc1;
                $inmuebleArray["pc2"] = $pc2;
                $inmuebleArray["car"] = $car;
                $inmuebleArray["cc1"] = $cc1;
                $inmuebleArray["cc2"] = $cc2;

                $inmueblesArray[] = $inmuebleArray;
            }
        }

        $ajax = $inmueblesArray;
    } catch (SoapFault $e) {
        // echo "Error SOAP: " . $e->getMessage();
        $ajax = [];
    } catch (Exception $e) {
        // echo "Error: " . $e->getMessage();
        $ajax =  [];
    }

    echo json_encode($ajax);

} else if (filter_input(INPUT_POST, "consultarInmueble")) {
    $provinciaCod = filter_input(INPUT_POST, "provincia");
    $provincia = $provincias[$provinciaCod];
    $municipio = filter_input(INPUT_POST, "municipio");
    $referenciaCatastral = filter_input(INPUT_POST, "referenciaCatastral");
    $numero = filter_input(INPUT_POST, "numero");


    try {
        $url = "http://ovc.catastro.meh.es/ovcservweb/OVCSWLocalizacionRC/OVCCallejero.asmx?WSDL";

        $client = new SoapClient($url);
        $response = $client->Consulta_DNPRC($provincia, $municipio, $referenciaCatastral)->any;

        // Decodificar la respuesta SOAP en formato JSON
        $xmlObject = simplexml_load_string($response);
        $json = json_decode(json_encode($xmlObject));

        $inmuebleArray = [];

        $ref = $referenciaCatastral;
        $ldt = (string) $json->bico->bi->ldt;
        $cn = (string) $json->bico->bi->idbi->cn;
        $luso = (string) $json->bico->bi->debi->luso;
        $sfc = (float) $json->bico->bi->debi->sfc;
        $ant = (int) $json->bico->bi->debi->ant;

        // Consulta a Firestore
        $curl = curl_init();
        $curlUrl = "https://firestore.googleapis.com/v1/projects/catastro-922df/databases/(default)/documents/provincias/".$provinciaCod;
        curl_setopt($curl, CURLOPT_URL, $curlUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $respuestaCurl = curl_exec($curl);
        curl_close($curl);
        $respuesta = json_decode($respuestaCurl);

        $precioM2 = (int) $respuesta->fields->preciom2->integerValue;
        $precio = $sfc * $precioM2;

        $inmuebleArray["ref"] = $ref;
        $inmuebleArray["ldt"] = $ldt;
        $inmuebleArray["cn"] = $cn;
        $inmuebleArray["luso"] = $luso;
        $inmuebleArray["sfc"] = $sfc;
        $inmuebleArray["ant"] = $ant;
        $inmuebleArray["precio"] = $precio;

        $ajax = $inmuebleArray;
    } catch (SoapFault $e) {
        // echo "Error SOAP: " . $e->getMessage();
        $ajax = [];
    } catch (Exception $e) {
        // echo "Error: " . $e->getMessage();
        $ajax = [];
    }

    echo json_encode($ajax);
}
