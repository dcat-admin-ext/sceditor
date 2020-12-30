<?php

namespace DcatAdminExt\Sceditor;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class SceditorServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/index.js',
    ];
	protected $css = [
		'css/index.css',
	];

	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

		//
		
	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
