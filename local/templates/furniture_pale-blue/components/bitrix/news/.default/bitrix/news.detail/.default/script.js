BX.ready(function () {

    function show_status(id) {
        if (id > 0) {
            let status = BX('report_status');
            if (status.hidden) {
                status.innerHTML += id;
                status.hidden = false;
            }
        }
    }

    if (AJAX_MODE === 'Y') { //в аякс-режиме вешаем обработчик
        BX('report').addEventListener('click', onClick);

        function onClick() {
            BX.ajax({
                url: PAGE_URL + '?report',
                method: 'GET',
                dataType: 'html',
                onsuccess: show_status,
            });
        }

    } else //в гет-режиме просто показываем статус
        show_status(REPORT_ID);
});