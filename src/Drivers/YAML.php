<?php namespace WPKG\Drivers;

use \WPKG\Interfaces\Export;

class YAML implements Export
{
    /**
     * Build configuration file from data in array
     *
     * @param   array $array - Incoming array for convert
     * @param   string $mode - Work mode, Hosts, Packages etc
     * @return  string
     */
    public function build(array $array, string $mode): string
    {
        // Set root parameter
        $array = [strtolower($mode) => $array];

        // Create object of YAML driver
        $yaml = new \EvilFreelancer\Yaml\Yaml();

        // Generate YAML
        return $yaml->set($array)->show();
    }
}
