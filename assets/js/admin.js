jQuery(document).ready(function (jQuery) {
  const lightbox = GLightbox({ });
});
document.addEventListener( 'click', function (e) {
    e = e || window.event;
    var target = e.target || e.srcElement;

    if (target.hasAttribute('href') ) {
        const url = new URL(target.getAttribute('href'));
        if( url['search'] === '?page=wc-settings&tab=posadzimy&section=help') {
            e.preventDefault();
            window.open(
                "https://posadzimy.pl/automatyzacje/woocommerce/",
                "_blank"
            );
        }
    }
}, false );
