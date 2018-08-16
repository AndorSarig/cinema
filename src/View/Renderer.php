<?php
/**
 * Created by PhpStorm.
 * User: andorsarig
 * Date: 13.08.2018
 * Time: 17:31
 */

namespace View;


class Renderer
{
    public function render(string $path, array $content)
    {
        extract($content);
        ob_start();
        require_once $path;
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function createView(array $pages, array $contents)
    {
        $output = '';
        foreach ($pages as $index => $page) {
            $output .= $this->renderSinglePage($page, $contents[$index]);
        }
        return $output;
    }

    public function renderSinglePage(string $path, array $content)
    {
        extract($content);
        ob_start();
        require_once $path;
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}