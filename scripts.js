class PositionManager {
    constructor() {
        this.input = document.getElementById('myInput');
        this.list = document.getElementById('list');
        this.updateAllPositions();
    }
    // Отправляет GET запрос,получает json с позициями из БД
    updateAllPositions() {
        fetch('/handler.php?action=getpositions')
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                this.clearList();
                if (data !== null) {
                    data.forEach(element => {
                        let newEl = document.createElement('li');
                        newEl.textContent = element.content;
                        this.list.appendChild(newEl);
                        let id = element.id;
                        this.addCloseButton(newEl, id);
                        this.input.value = '';
                    })
                }
            });
    };
    // Отправляет GET запрос на добавление позиции
    addPosition() {
        let content = this.input.value;
        fetch(`/handler.php?action=addposition&content=${content}`)
            .then(() => { this.updateAllPositions() });

    };
    // Отправляет GET запрос на поиск позиции, получает json с найдеными позициями
    searchPositions() {
        let content = this.input.value;
        fetch(`/handler.php?action=getsearchpositions&content=${content}`)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                this.clearList();
                if (data !== null) {
                    data.forEach(element => {
                        let newEl = document.createElement('li');
                        newEl.textContent = element.content;
                        this.list.appendChild(newEl);
                        let id = element.id;
                        this.addCloseButton(newEl, id);
                    })
                } else {
                    let newEl = document.createElement('li');
                    newEl.textContent = 'Ничего не найдено!';
                    this.list.appendChild(newEl);
                }
            });

    };
    // Добавляет к элементу кнопку close,принимает 2 параметра:body->элемент к которому мы добаляем кнопку close,id->id позиции(записи)
    addCloseButton(body, id) {
        let span = document.createElement("span");
        let txt = document.createTextNode("\u00D7");
        span.className = "close";
        span.appendChild(txt);
        body.appendChild(span);
        span.addEventListener('click', () => {
            fetch(`/handler.php?action=deleteposition&id=${id}`)
                .then(() => { this.clearList(); })
                .then(() => { this.updateAllPositions(); })
        })

    }
    // Очищает список позиций
    clearList() {
        let li = document.querySelectorAll('li');
        li.forEach((element) => {
            this.list.removeChild(element);
        })
    }
}

let positionManager = new PositionManager;


