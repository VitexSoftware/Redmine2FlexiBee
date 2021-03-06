<?php

namespace Redmine2AbraFlexi;

include_once '../vendor/autoload.php';

\Ease\Shared::instanced()->loadConfig('../config.json',true);

$oPage = new \Ease\TWB\WebPage('PDF');

$embed    = $oPage->getRequestValue('embed');
$id       = $oPage->getRequestValue('id');
$evidence = $oPage->getRequestValue('evidence');


$document = new \AbraFlexi\RO(is_numeric($id) ? intval($id) : $id,
    ['evidence' => $evidence]);

if (!is_null($document->getMyKey())) {
    $documentBody = $document->getInFormat('pdf');

    if ($embed != 'true') {
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename='.$document->getEvidence().'_'.$document.'.pdf');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
    } else {
        header('Content-Type: application/pdf');
    }
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: '.strlen($documentBody));
    echo $documentBody;
} else {
    die(_('Wrong call'));
}
