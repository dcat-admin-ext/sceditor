<?php

namespace DcatAdminExt\Sceditor;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;

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

        Admin::booting(function () {
            Form::extend('sceditor', \DcatAdminExt\Sceditor\Form\Sceditor::class);
        });

	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
