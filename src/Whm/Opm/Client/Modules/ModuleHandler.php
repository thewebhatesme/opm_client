<?php

namespace Whm\Opm\Client\Modules;

class ModuleHandler
{

    static public function getModules ()
    {
        $modules = array ("Whm\Opm\Client\Modules\Messure\HttpArchive\HttpArchive", "Whm\Opm\Client\Modules\Setup\PhantomJS\PhantomJS",
                "Whm\Opm\Client\Modules\Setup\Config\Config");

        foreach( $modules as $module ) {
            $moduleObjects[] = new $module;
        }

        return $moduleObjects;
    }
}