<?php
/**
 * Paginator
 *
 * Data for selecting a page of records
 */
class Paginator
{
    /**
     * Number of records to return
     * @var int
     */
    public $limit;
    /**
     * Number of records to skip before the page
     * @var int
     */
    public $offset;

    public $previous;
    public $next;
    /**
     * Constructor
     * @param int $page Page number
     * @param int $records_per_page Number of records per page
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