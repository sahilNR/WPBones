<?php


namespace WPKirk\WPBones\Foundation;


use WPKirk\WPBones\Support\ServiceProvider;

abstract class WordPressCustomBlockServiceProvider extends ServiceProvider
{

    protected $id = 'gutenberg-example';

    protected $editor_style = false;

    protected $style = false;

    protected $dependencies = ['wp-block-editor', 'wp-blocks', 'wp-element', 'wp-i18n', 'wp-polyfill'];


    protected function basePath()
    {
        return $this->plugin->getBasePath();
    }

    protected function baseUri()
    {
        return $this->plugin->getBaseUri();
    }

    /**
     * You may override this method in order to register your own actions and filters.
     *
     */
    public function boot()
    {
        // You may override this method
    }


    public function register()
    {
        $this->boot();
        wp_register_script(
            $this->id,
            $this->baseUri() . '/build/index.js',
            $this->dependencies,
            fileatime($this->basePath() . '/build/index.js')
        );


        if ($this->editor_style !== false && !empty($this->editor_style)) {
            wp_register_style(
                $this->id . '-editor',
                $this->baseUri() . $this->editor_style,
                array('wp-edit-blocks'),
                filemtime($this->baseUri() . $this->editor_style)
            );
        }


        if ($this->style !== false && !empty($this->style)) {
            wp_register_style(
                $this->id,
                $this->baseUri() . $this->style,
                array(),
                filemtime($this->baseUri() . $this->style)
            );
        }

        register_block_type('WPKirk/' . $this->id, array(
            'style' => $this->style ? $this->id : null,
            'editor_style' => $this->editor_style ? $this->id . '-editor' : null,
            'editor_script' => $this->id,
        ));
    }

}
