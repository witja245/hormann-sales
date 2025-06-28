document.addEventListener("DOMContentLoaded", function () {
    const showBtn = document.querySelector('.load-more');
    if (showBtn) {
        let url = showBtn.getAttribute('data-url');    //  URL, из которого будем брать элементы

        document.querySelector('.load-more').addEventListener('click', function () {
            var targetContainer = document.querySelector('.catalogue__row');          //  Контейнер, в котором хранятся элементы

            var newXHR = new XMLHttpRequest();
            newXHR.open('GET', url);
            newXHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            newXHR.send();

            newXHR.onreadystatechange = function () {
                if (newXHR.readyState === 4) {
                    if (newXHR.status === 200) {
                        var parser = new DOMParser();
                        var data = parser.parseFromString(newXHR.response, 'text/html');

                        var elements = data.querySelector('.catalogue__row').querySelectorAll('.catalogue__col'),  //  Ищем элементы
                            pagination = data.querySelector('.pagination.wow'), //  Ищем навигацию
                            paginationLinks = pagination.querySelector('ul'),
                            load = pagination.querySelector('.load-more')

                        const pagunationInHtml = document.querySelector('.pagination.wow');
                        const paginationRowInHtml = pagunationInHtml.querySelector('.pagination__row');
                        const paginationLinksInHtml = paginationRowInHtml.querySelector('ul');


                        load ? url = load.getAttribute('data-url') : showBtn.remove();

                        paginationLinksInHtml.remove();
                        paginationRowInHtml.prepend(paginationLinks);

                        for(var i = 0; i < elements.length; i++){
                            targetContainer.append(elements[i]);   //  Добавляем посты в конец контейнера
                        }
                    } else {
                        console.log('404')
                    }
                }
            }

        });
    }
});