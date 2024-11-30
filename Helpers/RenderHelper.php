<?php

namespace Helpers;
class RenderHelper
{

    /**
     * @param string $view
     * @param array $data
     * @return void
     */
    public function render(string $view, array $data = []): void
    {
        extract($data);
        include dirname(__DIR__) . "/Views/$view.php";
    }
}