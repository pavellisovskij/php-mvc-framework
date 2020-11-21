<?php

namespace app\lib;

class Paginator
{
    private $buttons = [];

    function __construct(int $pages, int $page, int $side_buttons_limit, string $link)
    {
        // Ссылки "назад" и "на первую страницу"
        if ($page >= 2) {
            // Значение page= для первой страницы всегда равно единице
            $this->add($link, 1, 'alert alert-light', '<<');
            // Предыдущая страница page=-1
            $this->add($link, $page - 1, 'alert alert-light', '<');
        }

        // Узнаем с какой ссылки начинать вывод
        $start = $page - $side_buttons_limit;
        // Узнаем номер последней ссылки для вывода
        $end = $page + $side_buttons_limit;

        // Выводим ссылки на все страницы
        // Начальное число $j в нашем случае должно равнятся единице, а не нулю
        for ($j = 1; $j <= $pages; $j++) {

            // Выводим ссылки только в том случае, если их номер больше или равен
            // начальному значению, и меньше или равен конечному значению
            if ($j >= $start && $j <= $end) {

                // Выделяем ссылку на текущую страницу
                if ($j == $page) {
                    $this->add($link, $page, 'alert alert-info', $j);
                } // Ссылки на остальные страницы
                else {
                    $this->add($link, $j, 'alert alert-light', $j);
                }
            }
        }

        // Выводим ссылки "вперед" и "на последнюю страницу"
        if ($j > $page && $page + 1 < $j) {
            // Следующая страница
            $this->add($link, $page + 1, 'alert alert-light', '>');
            // Последняя страница
            $this->add($link, $page - 1, 'alert alert-light', '>>');
        }
    }

    private function add(string $link, int $page, string $class, string $symbol) {
        $this->buttons[] = '<a href="' . $link . $page . '" class="' . $class . '" role="alert">' . $symbol . '</a>';
    }

    public function render() {
        echo '<div class="pagination justify-content-center">';

        foreach ($this->buttons as $button) echo $button;

        echo '</div>';
    }
}