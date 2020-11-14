<?php


namespace Source\Library\Paginator;


class Paginator
{
    /** @var int */
    private $page;

    /** @var int */
    private $pages;

    /** @var int */
    private $rows;

    /** @var int */
    private $limit;

    /** @var int */
    private $offset;

    /** @var int */
    private $range;

    /** @var string */
    private $link;

    /** @var string */
    private $title;

    /** @var string */
    private $class;

    /** @var string */
    private $hash;

    /** @var array */
    private $first;

    /** @var array */
    private $last;

    /**
     * Paginator constructor.
     * @param string|null $link
     * @param string|null $title
     * @param array|null $first
     * @param array|null $last
     */
    public function __construct(string $link = null, string $title = null, array $first = null, array $last = null)
    {
        $this->link = ($link ?? "?page=");
        $this->title = ($title ?? "Página");
        $this->first = ($first ?? ["Primeira página", "<<"]);
        $this->last = ($last ?? ["Última página", ">>"]);
    }

    /**
     * @param int $rows
     * @param int $limit
     * @param int|null $page
     * @param int $range
     * @param string|null $hash
     */
    public function pager(int $rows, int $limit = 10, int $page = null, int $range = 3, string $hash = null): void
    {
        $this->rows = $this->toPositive($rows);
        $this->limit = $this->toPositive($limit);
        $this->range = $this->toPositive($range);
        $this->pages = (int) ceil($this->rows / $this->limit);
        $this->page = ($page <= $this->pages ? $this->toPositive($page) : $this->pages);

        $this->offset = (($this->page * $this->limit) - $this->limit >= 0 ? ($this->page * $this->limit) - $this->limit : 0);
        $this->hash = (!empty($hash) ? "#{$hash}" : null);

        if ($this->rows && $this->offset >= $this->rows) {
            header("Location: {$this->link}" . ceil($this->rows / $this->limit));
            exit;
        }
    }

    /**
     * @return int
     */
    public function limit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function offset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function page()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function pages()
    {
        return $this->pages;
    }

    /**
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param string $cssClass
     * @param bool $fixedFirstAndLastPage
     * @return null|string
     */
    public function render(string $cssClass = null, bool $fixedFirstAndLastPage = true): ?string
    {
        $this->class = $cssClass ?? "page";

        if ($this->rows > $this->limit) {
            $paginator  = "<nav class='{$this->class}'  style='height: 40px;'>";
            $paginator .= "<ul class='pagination justify-content-end'>";
            $paginator .= $this->firstPage($fixedFirstAndLastPage);
            $paginator .= $this->beforePages();
            $paginator .= $this->activePage();
            $paginator .= $this->afterPages();
            $paginator .= $this->lastPage($fixedFirstAndLastPage);
            $paginator .= "</ul>";
            $paginator .= "</nav>";

            return $paginator;
        }

        return null;
    }

    public function renderHeader(): ?string
    {
        if ($this->getRows()) {
            return
                "<div class='row bg-light text-dark m-0'>
                    <div class='col-md-6'>
                        <p class='text-left my-2'>{$this->getRows()} itens encontrados</p>
                    </div>
                    <div class='col-md-6'>
                        {$this->render()}
                    </div>
                </div>";
        }

        return null;
    }

    /**
     * @return null|string
     */
    private function beforePages(): ?string
    {
        $before = null;
        for ($iPag = $this->page - $this->range; $iPag <= $this->page - 1; $iPag++) {
            if ($iPag >= 1) {
                $before .=
                    "<li class='page-item'>
                        <a class='{$this->class}-link' title='{$this->title} {$iPag}' href='{$this->link}{$iPag}{$this->hash}'>
                            {$iPag}
                        </a>
                    </li>";
            }
        }

        return $before;
    }

    /**
     * @return string|null
     */
    private function afterPages(): ?string
    {
        $after = null;
        for ($dPag = $this->page + 1; $dPag <= $this->page + $this->range; $dPag++) {
            if ($dPag <= $this->pages) {
                $after .=
                    "<li class='page-item'>
                        <a class='{$this->class}-link' title='{$this->title} {$dPag}' href='{$this->link}{$dPag}{$this->hash}'>
                            {$dPag}
                        </a>
                    </li>";
            }
        }

        return $after;
    }

    public function firstPage($fixedFirstAndLastPage): ?string
    {
        if ($fixedFirstAndLastPage || $this->page != 1) {
            return
                "<li class='page-item'>
                    <a class='{$this->class}-link' title='{$this->first[0]}' href='{$this->link}1{$this->hash}'>
                        {$this->first[1]}
                    </a>
                </li>";
        }

        return null;
    }

    public function lastPage($fixedFirstAndLastPage): ?string
    {
        if ($fixedFirstAndLastPage || $this->page != $this->pages) {
            return
                "<li class='page-item'>
                    <a class='{$this->class}-link' title='{$this->last[0]}' href='{$this->link}{$this->pages}{$this->hash}'>
                        {$this->last[1]}
                    </a>
                </li>";
        }

        return null;
    }

    public function activePage()
    {
        return
            "<li class='{$this->class}-item active' aria-current='page'>
                <span class='{$this->class}-link'>
                    {$this->page}
                    <span class='sr-only'>(current)</span>
                </span>
            </li>";
}
    /**
     * @param $number
     * @return int
     */
    private function toPositive($number): int
    {
        return ($number >= 1 ? $number : 1);
    }
}