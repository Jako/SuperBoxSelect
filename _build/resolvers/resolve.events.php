<?php
/**
 * Resolve events
 *
 * @package superboxselect
 * @subpackage build
 *
 * @var array $options
 * @var xPDOObject $object
 */

/**
 * @param xPDO $modx
 * @param string $name
 * @param integer $service see https://github.com/modxcms/revolution/blob/v2.3.2-pl/core/model/modx/modx.class.php#L2005-L2010
 * @return bool
 */
function createEvent(xPDO &$modx, $name, $service = 0)
{
    $success = true;
    $event = $modx->getObject('modEvent', [
        'name' => $name
    ]);
    if (!$event) {
        /** @var modEvent $event */
        $event = $modx->newObject('modEvent');
        $event->fromArray([
            'name' => $name,
            'service' => $service,
            'groupname' => 'SuperBoxSelect'
        ], '', true, true);
        if ($event->save()) {
            $modx->log(xPDO::LOG_LEVEL_INFO, 'System event "' . $name . '" was created.');
        } else {
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'System event "' . $name . '" was not created.');
            $success = false;
        }
    } else {
        $event->fromArray([
            'name' => $name,
            'service' => $service,
            'groupname' => 'SuperBoxSelect'
        ], '', true, true);
        if ($event->save()) {
            $modx->log(xPDO::LOG_LEVEL_INFO, 'System event "' . $name . '" was updated.');
        } else {
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'System event "' . $name . '" can\'t be updated.');
            $success = false;
        }
    }
    return $success;
}

/**
 * @param xPDO $modx
 * @param string $name
 * @return bool
 */
function removeEvent(xPDO &$modx, $name)
{
    $success = true;
    /** @var modEvent $event */
    $event = $modx->getObject('modEvent', [
        'name' => $name
    ]);
    if ($event) {
        $success = $event->remove();
        if ($success) {
            $modx->log(xPDO::LOG_LEVEL_INFO, 'System event "' . $name . '" was removed.');
        } else {
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'System event "' . $name . '" was not removed.');
        }
    }
    return $success;
}

$events = [
    'OnSuperboxselectTypeOptions'
];

/** @var xPDO $modx */
$modx =& $object->xpdo;

$success = true;
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        foreach ($events as $event) {
            $created = createEvent($modx, $event, 6);
            $success = $success && $created;
        }
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        foreach ($events as $event) {
            $removed = removeEvent($modx, $event);
            $success = $success && $removed;
        }
        break;
}
return $success;
