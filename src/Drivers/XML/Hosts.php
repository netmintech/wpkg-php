<?php namespace WPKG\Drivers\XML;
use WPKG\Interfaces\Host;

/**
 * Class HostsXML class with all basic parameters
 *
 * @link https://wpkg.org/Hosts.xml
 * @package WPKG\Drivers\XML
 */
class Hosts extends \WPKG\Hosts
{
    /**
     * Current namespace
     * @var string
     */
    const ROOT = 'hosts:wpkg';

    /**
     * List of attributes
     * @var array
     */
    const ROOT_ATTRIBUTES = [
        'xmlns:hosts' => 'http://www.wpkg.org/hosts',
        'xmlns:wpkg' => 'http://www.wpkg.org/wpkg',
        'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
        'xsi:schemaLocation' => 'http://www.wpkg.org/hosts xsd/hosts.xsd'
    ];

    /**
     * XSD schema of XML
     * @var string
     */
    const XSD = __DIR__ . '/../../vendor/wpkg/wpkg-js/xsd/hosts.xsd';

    /**
     * Import XML into Hosts object
     *
     * @param   $array - Original array generated by XML
     * @return  \WPKG\Interfaces\Hosts
     */
    public function import(array $array): \WPKG\Interfaces\Hosts
    {
        $hosts = new \WPKG\Hosts();

        // Parse array items
        foreach ($array as $item) {
            $host = new \WPKG\Host();
            $attrs = $item['@attributes'];
            if (isset($attrs['name'])) $host->with('name', $attrs['name']);

            if (isset($item['profile'])) {
                $profiles[] = $attrs['profile-id'];
                foreach ($item['profile'] as $profile) {
                    $profiles[] = $profile['@attributes']['id'];
                }
                $host->with('profile-id', $profiles);
            } else {
                if (isset($attrs['profile-id'])) $host->with('profile-id', $attrs['profile-id']);
            }

            $hosts->setHost($host);
        }
        return $hosts;
    }
}
