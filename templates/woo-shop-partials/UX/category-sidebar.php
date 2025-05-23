<?php
namespace pockets_woo\templates\woo_shop_partials\UX;

class category_sidebar {

    use \pockets\traits\init;

    public function __construct( 

        public array $currentTermIds = [],
        public array $parentQuery = []

    ) {}

    private function isTermActive( int $termId ) : bool {
        
        if ( in_array( $termId, $this->currentTermIds, true ) ) {
            return true;
        }
        
        foreach ( $this->currentTermIds as $currentTermId ) {
            if ( in_array( $termId, get_ancestors( $currentTermId, 'product_cat', 'taxonomy' ) ) ) {
                return true;
            }
        }
        
        return false;

    }

    private function renderTerm( array $term, string $parentId = 'accordion' ) : string {
        
        static $count = 0;

        $count++;

        $termId = "{$parentId}-{$count}";
        $termLink = esc_url( get_term_link( $term['ID'] ) );

        $children = \pockets::crud('term')::init( $term['ID'] )->read( [
            'terms:<=' => [
                'items:<=' => [ 
                    'ID', 
                    'name', 
                    'count' 
                ]
            ]
        ] );

        $isActive = $this->isTermActive( $term['ID'] );
        $collapseClass = $isActive ? 'show' : '';
        $buttonClass = $isActive ? '' : 'collapsed';

        $childrenHTML = join( 
            array_map( 
                array: $children,
                callback: fn( $child ) => $this->renderTerm( $child, $termId ), 
            ) 
        );

        $triggerHTML = !empty( $children ) ? sprintf(
            <<<HTML
                <button 
                    style="width: auto" 
                    class="accordion-button $buttonClass bg-transparent p-2 fw-8 fs-14" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapse-$termId" 
                    aria-expanded="%s" 
                    aria-controls="collapse-$termId"
                ></button>
            HTML,
            $isActive ? 'true' : 'false',
        ) : '';

        return sprintf(
            <<<HTML
            <div class="accordion-item border-0">
                <h2 class="accordion-header m-0" id="heading-$termId">
                    <div class="d-flex align-items-center ps-2">
                        <a href="$termLink" class="text-decoration-none flex-grow-1 text-grey-800 fw-7 lh-20 fs-14 pe-2 py-2">
                            {$term['name']} ({$term['count']})
                        </a>
                        {$triggerHTML} 
                    </div>
                </h2>
                <div 
                    id="collapse-$termId" 
                    class="accordion-collapse collapse $collapseClass" 
                    aria-labelledby="heading-$termId" 
                    data-bs-parent="#$parentId"
                >
                    <div class="accordion-body py-1 pe-0 ps-3">
                        {$childrenHTML}
                    </div>
                </div>
            </div>
            HTML 
        );

    }

    public function render(): string {

        $parents = \pockets::crud( 'terms' )::init( $this->parentQuery )->read( [
            'items:<=' => [ 
                'name', 
                'ID', 
                'count'
            ]
        ] );

        return sprintf(
            <<<HTML
                <div class='product-archive-sidebar'>
                    <div class='accordion'>
                        %s
                    </div>
                </div>
            HTML,
            join( 
                array_map( 
                    array: $parents,
                    callback: fn( $term ) => $this->renderTerm( $term, 'accordion-main' ), 
                ) 
            )
        );

    }

}
