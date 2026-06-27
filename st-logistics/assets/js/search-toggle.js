( function () {
    var btn = document.querySelector( '.st-header-search-toggle' );
    var box = document.getElementById( 'st-header-search-box' );
    if ( ! btn || ! box ) { return; }

    /* Collect all focusable elements inside the search box */
    function getFocusable() {
        return Array.prototype.slice.call(
            box.querySelectorAll( 'input, button, select, textarea, a[href], [tabindex]:not([tabindex="-1"])' )
        ).filter( function ( el ) { return ! el.disabled && ! el.hasAttribute( 'hidden' ); } );
    }

    function openSearch() {
        box.removeAttribute( 'hidden' );
        btn.setAttribute( 'aria-expanded', 'true' );
        btn.setAttribute( 'aria-label', btn.getAttribute( 'data-label-close' ) || 'Close search' );
        var field = box.querySelector( 'input[type="search"]' );
        if ( field ) { field.focus(); }
    }

    function closeSearch() {
        box.setAttribute( 'hidden', '' );
        btn.setAttribute( 'aria-expanded', 'false' );
        btn.setAttribute( 'aria-label', btn.getAttribute( 'data-label-open' ) || 'Open search' );
        btn.focus();
    }

    /* Store original label for toggling — close label comes from wp_localize_script */
    btn.setAttribute( 'data-label-open', btn.getAttribute( 'aria-label' ) );
    btn.setAttribute( 'data-label-close', ( typeof stSearchToggle !== 'undefined' && stSearchToggle.closeLabel ) ? stSearchToggle.closeLabel : 'Close search' );

    /* Toggle on button click */
    btn.addEventListener( 'click', function () {
        if ( box.hasAttribute( 'hidden' ) ) {
            openSearch();
        } else {
            closeSearch();
        }
    } );

    /* ESC key closes and returns focus */
    document.addEventListener( 'keydown', function ( e ) {
        if ( ( e.key === 'Escape' || e.keyCode === 27 ) && ! box.hasAttribute( 'hidden' ) ) {
            closeSearch();
        }
    } );

    /* Tab-key focus trap: loop is btn → [box elements] → btn */
    box.addEventListener( 'keydown', function ( e ) {
        if ( e.key !== 'Tab' && e.keyCode !== 9 ) { return; }
        var focusable = getFocusable();
        if ( ! focusable.length ) { return; }
        var first = focusable[ 0 ];
        var last  = focusable[ focusable.length - 1 ];
        if ( e.shiftKey ) {
            if ( document.activeElement === first ) {
                e.preventDefault();
                btn.focus();
            }
        } else {
            if ( document.activeElement === last ) {
                e.preventDefault();
                btn.focus();
            }
        }
    } );

    /* Tab on the toggle button itself loops into / out of the box */
    btn.addEventListener( 'keydown', function ( e ) {
        if ( e.key !== 'Tab' && e.keyCode !== 9 ) { return; }
        if ( box.hasAttribute( 'hidden' ) ) { return; }
        var focusable = getFocusable();
        if ( ! focusable.length ) { return; }
        if ( e.shiftKey ) {
            e.preventDefault();
            focusable[ focusable.length - 1 ].focus();
        } else {
            e.preventDefault();
            focusable[ 0 ].focus();
        }
    } );

    /* Close on outside click */
    document.addEventListener( 'click', function ( e ) {
        if ( ! btn.contains( e.target ) && ! box.contains( e.target ) ) {
            if ( ! box.hasAttribute( 'hidden' ) ) {
                box.setAttribute( 'hidden', '' );
                btn.setAttribute( 'aria-expanded', 'false' );
                btn.setAttribute( 'aria-label', btn.getAttribute( 'data-label-open' ) );
            }
        }
    } );
} )();
