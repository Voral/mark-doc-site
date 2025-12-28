document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('.side .m-doc-menu__item:has(.m-doc-menu__item) > .m-doc-menu__link');
    items.forEach(function (item) {
        item.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            item.parentNode.classList.toggle('m-doc-menu_active');
            return false;
        });

    })
})
