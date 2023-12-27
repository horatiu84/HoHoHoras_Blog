<?php
/**
 * Paginator
 *
 * Informatii pentru a selecta un anumit numar de articole per pagina
 */
class Paginator
{
    /**
     * Numarul de inregistrari pe pagina
     * @var int
     */
    public $limit;
    /**
     * Numarul de inregistrari pe care sa le sarim
     * @var int
     */
    public $offset;

    public $previous;
    public $next;
    /**
     * Constructor
     * @param int $page Numarul paginii
     * @param int $records_per_page Numarul de inregistrari pe pagina
     */
    public function __construct($page,$records_per_page,$total_records){
        $page=filter_var($page,FILTER_VALIDATE_INT,[
            'options' => [
                'default'=>1,
                'min_range'=>1
            ]
        ]);
        $this->limit = $records_per_page;
        $this->offset=$records_per_page*($page-1);


        $total_pages = ceil($total_records/$records_per_page);
        if ($page < $total_pages) {
            $this->next=$page+1;
        }

        if ($page>1) {
            $this->previous=$page-1;
        }

    }
}

// resurse : - https://stackoverflow.com/questions/41777993/php-pagination-next-previous-button
//          - https://programmopedia.com/pagination-in-php/
//          - https://www.sqltutorial.org/sql-limit/