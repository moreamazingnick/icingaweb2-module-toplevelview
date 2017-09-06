<?php

namespace Icinga\Module\Toplevelview;

use Icinga\Application\Icinga;
use Icinga\Util\DirectoryIterator;
use ArrayIterator;

class ConfigStore extends ArrayIterator
{
    const DEFAULT_CONFIG_DIR = '_default';

    protected $config_dir;

    protected static $instances = array();

    /**
     * Initialize the store
     *
     * @param string $config_dir
     */
    public function __construct($config_dir = self::DEFAULT_CONFIG_DIR)
    {
        if ($config_dir !== self::DEFAULT_CONFIG_DIR) {
            $this->config_dir = $config_dir;
        } else {
            $this->config_dir = sprintf(
                '%s/views',
                Icinga::app()->getModuleManager()->getModule('toplevelview')->getConfigDir()
            );
        }

        parent::__construct($this->readDir());
    }

    protected function readDir()
    {
        $dir = new DirectoryIterator($this->config_dir, '.yml');
        $data = array();
        foreach ($dir as $name => $file) {
            $name = basename($name, '.yml');
            $data[$name] = $name;
        }
        return $data;
    }

    /**
     * Get the instance for a config dir
     *
     * @param string $config_dir
     *
     * @return mixed
     */
    public static function forConfigDir($config_dir = self::DEFAULT_CONFIG_DIR)
    {
        if (! array_key_exists($config_dir, self::$instances)) {
            self::$instances[$config_dir] = new static($config_dir);
        }
        return self::$instances[$config_dir];
    }

    public function offsetGet($index)
    {
        var_dump($index);
        parent::offsetGet($index); // TODO: Change the autogenerated stub
    }

    public function offsetSet($index, $newval)
    {
        parent::offsetSet($index, $newval); // TODO: Change the autogenerated stub
    }
}
