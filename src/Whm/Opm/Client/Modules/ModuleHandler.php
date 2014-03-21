<?php

namespace Whm\Opm\Client\Modules;

class ModuleHandler
{

    static public function getModules ()
    {
        $modules = array ("Whm\Opm\Client\Modules\Messure\HttpArchive\Listener", "Whm\Opm\Client\Modules\Setup\PhantomJS\PhantomJs", "Whm\Opm\Client\Modules\Setup\Config\Config",
                "Whm\Opm\Client\Modules\Messure\HttpStatusOk\Listener");

        foreach ($modules as $module) {
            $moduleObjects[] = new $module();
        }

        return $moduleObjects;
    }
}