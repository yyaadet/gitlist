<?php

namespace GitList;

class Config
{
    protected $data;

<<<<<<< HEAD
    public function __construct($file)
    {
        if (!file_exists($file)) {
            die("Please, create the config.ini file.");
        }

        $this->data = parse_ini_file('config.ini', true);
=======
    public static function fromFile($file) {
        if (!file_exists($file)) {
            die(sprintf('Please, create the %1$s file.', $file));
        }
        $data = parse_ini_file($file, true);
        return new static($data);
    }

    public function __construct($data)
    {
        $this->data = $data;
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
        $this->validateOptions();
    }

    public function get($section, $option)
    {
        if (!array_key_exists($section, $this->data)) {
            return false;
        }

        if (!array_key_exists($option, $this->data[$section])) {
            return false;
        }

        return $this->data[$section][$option];
    }

    public function getSection($section)
    {
        if (!array_key_exists($section, $this->data)) {
            return false;
        }

        return $this->data[$section];
    }

    public function set($section, $option, $value)
    {
        $this->data[$section][$option] = $value;
    }

    protected function validateOptions()
    {
        if (!$this->get('git', 'repositories') || !is_dir($this->get('git', 'repositories'))) {
<<<<<<< HEAD
            die("Please, edit the config.ini file and provide your repositories directory");
        }
    }
}
=======
            die("Please, edit the config file and provide your repositories directory");
        }
    }
}
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
