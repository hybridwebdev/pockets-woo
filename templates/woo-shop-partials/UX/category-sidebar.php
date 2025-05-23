<?php
namespace pockets_woo\templates\woo_shop_partials\UX;

class category_sidebar {

    use \pockets\traits\init;

    public function __construct( 

        public array $currentTermIds = [],
        public array $parentQuery = [],
        public string $taxonomy

    ) {}

    private function isTermActive( int $termId ) : bool {
        
        if ( in_array( $termId, $this->currentTermIds ) ) {
            return true;
        }
        
        foreach ( $this->currentTermIds as $currentTermId ) {
            if ( in_array( $termId, get_ancestors( $currentTermId, $this->taxonomy, 'taxonomy' ) ) ) {
                return true;
            }
        }
        
        return false;

    }

    private function renderTerm( array $term, int $parentId ) : string {

        $termLink = esc_url( get_term_link( $term['ID'] ) );

        $isActive = $this->isTermActive( $term['ID'] );
        $collapseClass = $isActive ? 'show' : '';
        $buttonClass = $isActive ? '' : 'collapsed';

        $targetID = uniqid($term['ID']);

        $LinkClass = in_array( $term['ID'], $this->currentTermIds ) ? "active" : "";

        $children = \pockets::crud( 'term' )::init( $term['ID'] )->read( [
            'terms:<=' => [
                'items:<=' => [ 
                    'ID', 
                    'name', 
                    'count' 
                ]
            ]
        ] );
        
        $childrenHTML = join( 
            array_map( 
                array: $children,
                callback: fn( $child ) => $this->renderTerm( $child, $term['ID'] ), 
            ) 
        );

        $childrenHTML = count( $children ) == 0 ? "" : sprintf(
            <<<HTML
                <div 
                    id="collapse-{$targetID}" 
                    class="accordion-collapse collapse {$collapseClass}" 
                >
                    <div class="accordion-body p-0 px-1">
                        {$childrenHTML}
                    </div>
                </div>
            HTML
        );

        $triggerHTML = count( $children ) == 0 ? "" : sprintf(
            <<<HTML
                <span>
                    <button 
                        class="accordion-button bg-transparent {$buttonClass} p-1" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#collapse-{$targetID}" 
                    ></button>
                </span>
            HTML 
        );

        return sprintf(
            <<<HTML
                <div
                    class="accordion-item border-0" 
                >
                    <span class="d-flex align-items-center">
                        <a 
                            href="{$termLink}" 
                            class="text-decoration-none flex-grow-1 fw-8 lh-20 fs-18 p-1 {$LinkClass}"
                        >
                            {$term['name']} (<span class='accordion-item-count fw-8'>{$term['count']}</span>)
                        </a>
                        {$triggerHTML} 
                    </span>
                    {$childrenHTML}
                </div>
            HTML 
        );

    }

    public function render() : string {

        $parents = \pockets::crud( 'terms' )::init( $this->parentQuery )->read( [
            'items:<=' => [ 
                'name', 
                'ID', 
                'count'
            ]
        ] );

        $childrenHTML = join( 
            array_map( 
                array: $parents,
                callback: fn( $term ) => $this->renderTerm( $term, $term['ID'] ), 
            ) 
        );

        return sprintf(
            <<<HTML
                <div class='category-accordion accordion p-1 bg-white'>
                    {$childrenHTML}
                </div>
            HTML
        );

    }

}
