document.addEventListener("DOMContentLoaded", function (event) {
    const $links = document.querySelectorAll('.__confirm')
    for(let $link of $links) {
        $link.addEventListener('click', function (e) {
            e.preventDefault();
            const proceed = confirm('Jste si jisti?');
            if (proceed) {
                window.location.href = this.href;
            }
        });
    }
});