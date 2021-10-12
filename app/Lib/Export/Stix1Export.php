<?php

App::uses('StixExport', 'Export');

class Stix1Export extends StixExport
{
    protected $__attributes_limit = 15000;
    protected $__default_version = '1.1.1';
    protected $__sane_versions = array('1.1.1', '1.2');
    private $__script_name = 'misp2stix.py ';
    private $__baseurl = null;
    private $__org = null;

    protected function __initiate_framing_params()
    {
        $this->__baseurl = escapeshellarg(Configure::read('MISP.baseurl'));
        $this->__org = escapeshellarg(Configure::read('MISP.org'));
        return $this->pythonBin() . ' ' . $this->__framing_script . ' stix1 -v ' . $this->__version . ' -n ' . $this->__baseurl . ' -o ' . $this->__org . ' -f ' . $this->__return_format . ' ' . $this->__end_of_cmd;
    }

    protected function __parse_misp_events(array $filenames)
    {
        $filenames = implode(' ', $filenames);
        $scriptFile = $this->__scripts_dir . $this->__script_name;
        return shell_exec($this->pythonBin() . ' ' . $scriptFile . '-v ' . $this->__version . ' -f ' . $this->__return_format . ' -o ' . $this->__org . ' -i ' . $filenames . $this->__end_of_cmd);
    }
}
