<?php

namespace Helpers;
class RenderHelper
{

    /**
     * @param string|int|float $data
     * @return void
     */
    public static function echo(string|int|float $data) : void
    {
        echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

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