<?php

namespace KilroyWeb\Klink;

use Illuminate\Support\Facades\Request;

class Klink
{

    protected $outputType = 'link';
    protected $activeClassName = 'active';
    protected $checkURLs = [];
    protected $containerElement = 'li';
    protected $containerClasses = [];
    protected $anchorClasses = [];
    protected $label = 'Link';
    protected $url = '#';

    public function showClass(){
        $this->outputType = 'activeClass';
        return $this;
    }

    public function container($containerElement)
    {
        $this->containerElement = $containerElement;
        return $this;
    }

    public function label($label)
    {
        $this->label = $label;
        return $this;
    }

    public function url($url, $applyURLHelper = true)
    {
        $klink = new static;
        if ($applyURLHelper) {
            $url = url($url);
        }
        $klink->url = $url;
        return $klink;
    }
    
    public function addAnchorClass($className){
        $this->anchorClasses[] = $className;
        return $this;
    }
    
    public function addContainerClass($className){
        $this->containerClasses[] = $className;
        return $this;
    }

    public function alsoCheck($urls=[]){
        $this->checkURLs = array_merge($this->checkURLs,$urls);
        return $this;
    }

    private function generateHTML()
    {
        $output = $this->label;
        $output = $this->wrapWithLink($output);
        $output = $this->wrapWithContainerElement($output);
        return $output;
    }

    private function wrapWithLink($html)
    {
        $classAttributeWithSpace = $this->anchorClassAttribute();
        if(!empty($classAttributeWithSpace)){
            $classAttributeWithSpace = ' '.$classAttributeWithSpace;
        }
        $prefix = '<a href="' . $this->url . '"' . $classAttributeWithSpace . '>';
        $suffix = '</a>';
        return $prefix . $html . $suffix;
    }

    private function containerClassAttribute()
    {
        $classes = $this->containerClasses();
        if (!empty($classes)) {
            return 'class="' . implode(' ', $classes) . '"';
        }
        return '';
    }

    private function anchorClassAttribute()
    {
        $classes = $this->anchorClasses();
        if (!empty($classes)) {
            return 'class="' . implode(' ', $classes) . '"';
        }
        return '';
    }

    private function currentURL()
    {
        return Request::url();
    }

    private function urlActive($url)
    {
        $currentURL = $this->currentURL();
        if($currentURL == $url){
            return true;
        }
        if($currentURL == url($url)){
            return true;
        }
        if (Request::is($url))
        {
            return true;
        }
        return false;
    }

    private function active()
    {
        $checkURLs = $this->checkURLs;
        $checkURLs[] = $this->url;
        foreach ($checkURLs as $checkURL) {
            if ($this->urlActive($checkURL)) {
                return true;
            }
        }
        return false;
    }

    private function containerClasses()
    {
        $classes = $this->containerClasses;
        if ($this->active()) {
            if (!in_array($this->activeClassName, $classes)) {
                $classes[] = $this->activeClassName;
            }
        }
        return $classes;
    }

    private function anchorClasses()
    {
        $classes = $this->anchorClasses;
        if ($this->active() && !$this->containerElement) {
            if (!in_array($this->activeClassName, $classes)) {
                $classes[] = $this->activeClassName;
            }
        }
        return $classes;
    }

    private function wrapWithContainerElement($html)
    {
        if(!$this->containerElement){
            return $html;
        }
        $classAttributeWithSpace = $this->containerClassAttribute();
        if(!empty($classAttributeWithSpace)){
            $classAttributeWithSpace = ' '.$classAttributeWithSpace;
        }
        $prefix = '<' . $this->containerElement . $classAttributeWithSpace . '>';
        $suffix = '</' . $this->containerElement . '>';
        return $prefix . $html . $suffix;
    }

    private function outputActiveClassName(){
        if($this->active()){
            return $this->activeClassName;
        }
        return '';
    }

    public function __toString()
    {
        if($this->outputType == 'activeClass'){
            return $this->outputActiveClassName();
        }
        return $this->generateHTML();
    }

}
