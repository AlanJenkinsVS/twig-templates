<?php
use Twig\Extension\AbstractExtension;

class MyTwigExtension extends AbstractExtension
{
  public $scripts = ['foo'];
  public $assets = [];

  public function getFunctions()
  {
    return array(
      'registerScript' => new \Twig_Function_Method($this, 'registerScript'),
      'preload_asset' => new \Twig_Function_Method($this, 'preloadAsset'),
      'asset_preload' => new \Twig_Function_Method($this, 'assetPreload'),
      'asset_scripts' => new \Twig_Function_Method($this, 'assetScripts')
    );
  }

  public function getGlobals()
  {
    return [
      'amp_scripts' => $this->scripts,
    ];
  }

  public function assetPreload() {
    $dom = new DOMDocument("1.0");

    foreach($this->assets as $asset)
    {
      $link = $dom->createElement("link");

      foreach($asset as $attr => $value)
      {
        // @todo add an $attr whitelist and check it here
        $link->setAttribute($attr, $value);
      }

      $dom->appendChild($link);
    }

    echo $dom->saveHTML();
  }

  public function assetScripts() {
    $dom = new DOMDocument("1.0");

    foreach($this->scripts as $asset)
    {
      if (is_array($asset)) {
        $script = $dom->createElement("script");

        foreach($asset as $attr => $value)
        {
          // @todo add an $attr whitelist and check it here
          if(is_bool($value)) {
            $script->setAttribute($attr, $attr);
          } else {
            $script->setAttribute($attr, $value);
          }
        }

        $dom->appendChild($script);
      }
    }

    echo $dom->saveHTML();
  }

  public function preloadAsset($asset)
  {
    $this->assets[] = $asset;
  }

  public function registerScript($script)
  {
    $this->scripts[] = $script;
  }
}
