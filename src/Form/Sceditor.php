<?php

namespace DcatAdminExt\Sceditor\Form;

use Dcat\Admin\Form\Field;
use Dcat\Admin\Support\Helper;

class Sceditor extends Field
{
    /**
     * @var string
     */
    protected $view = 'dcat-admin-ext.sceditor::sceditor';

    /**
     * @var array
     */
    protected static $css = [
        '@extension/dcat-admin-ext/sceditor/minified/themes/square.min.css',
        '@admin/dcat/extra/upload.css'
    ];

    /**
     * @var array
     */
    protected static $js = [
        '@extension/dcat-admin-ext/sceditor/minified/sceditor.min.js',
        '@extension/dcat-admin-ext/sceditor/languages/cn.js',
        '@extension/dcat-admin-ext/sceditor/minified/formats/bbcode.js',
        '@admin/dcat/plugins/webuploader/webuploader.min.js',
        '@admin/dcat/extra/upload.js',
    ];

    protected $options = [
        'format' => 'bbcode',
        'width' => '100%',
        'height' => '100px',
        'locale' => 'cn',
        'toolbar' => 'bold,italic,underline,strike,color,size|orderedlist,bulletlist,table|image|superscript,subscript,pastetext|source',
        'style' => 'minified/themes/content/default.min.css',
        'parserOptions' => [
            'removeEmptyTags' => false
        ],
        'enablePasteFiltering' => true,
        'bbcodeTrim' => true,
        'autoUpdate' => true,
        'emoticonsEnabled' => false,
        'autoExpand' => true,
        'readOnly' => false,
    ];

    protected $disk;

    protected $imageUploadDirectory = 'sceditor/images';

    /**
     * 设置文件上传存储配置.
     *
     * @param string $disk
     *
     * @return $this
     */
    public function disk(string $disk)
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * 设置图片上传文件夹.
     *
     * @param string $dir
     *
     * @return $this
     */
    public function imageDirectory(string $dir)
    {
        $this->imageUploadDirectory = $dir;

        return $this;
    }

    /**
     * 自定义图片上传接口.
     *
     * @param string $url
     *
     * @return $this
     */
    public function imageUrl(string $url)
    {
        return $this->mergeOptions(['images_upload_url' => $this->formatUrl(admin_url($url))]);
    }

    /**
     * 设置编辑器高度.
     *
     * @param int $height
     *
     * @return $this
     */
    public function height(int $height)
    {
        return $this->mergeOptions(['height' => $height. 'px']);
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function autoExpand(bool $value = true)
    {
        return $this->mergeOptions(['autoExpand' => $value]);
    }

    /**
     * @return array
     */
    protected function formatOptions()
    {
        $this->options['style'] = admin_asset('vendor/dcat-admin-extensions/dcat-admin-ext/sceditor/' . $this->options['style']);
        $this->options['readOnly'] = ! empty($this->attributes['readonly']) || ! empty($this->attributes['disabled']);

        if (empty($this->options['images_upload_url'])) {
            $this->options['images_upload_url'] = $this->defaultImageUploadUrl();
        }

        return $this->options;
    }

    /**
     * @return string
     */
    protected function defaultImageUploadUrl()
    {
        return $this->formatUrl(route(admin_api_route('tinymce.upload')));
    }

    /**
     * @param string $url
     *
     * @return string
     */
    protected function formatUrl(string $url)
    {
        return Helper::urlWithQuery(
            $url,
            [
                '_token' => csrf_token(),
                'disk'   => $this->disk,
                'dir'    => $this->imageUploadDirectory,
            ]
        );
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->addVariables([
            'options' => $this->formatOptions(),
        ]);

        return parent::render();
    }
}
