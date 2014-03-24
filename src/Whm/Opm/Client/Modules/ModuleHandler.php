<?php

namespace Whm\Opm\Client\Modules;

class ModuleHandler
{

    static public function getModules ()
    {
        $modules = array ("Whm\Opm\Client\Modules\Messure\HttpArchive\Listener", "Whm\Opm\Client\Modules\Setup\PhantomJs\Listener", "Whm\Opm\Client\Modules\Setup\Config\Listener",
                "Whm\Opm\Client\Modules\Messure\HttpStatus\Listener");

        foreach ($modules as $module) {
            $moduleObjects[] = new $module();
        }

        return $moduleObjects;
    }
}