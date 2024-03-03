const socket = new WebSocket("ws://127.0.0.1:2346");
const body = document.getElementById('bodyId')
const circle = document.getElementById('circleId')

if (body) {
    body.addEventListener('keyup', inputButton)
}

socket.onopen = function(event) {
    console.log("Соединение установлено");
};

socket.onmessage = function(event) {
    const data = JSON.parse(event.data)
    const top = data.top
    const left = data.left

    console.log(`Новые координаты от сервера: {top: ${top}, left: ${left}}`);
    circle.style.top = top
    circle.style.left = left
};

socket.onclose = function(event) {
    console.log("Соединение закрыто");
};

function inputButton(event) {
    const key = event.key
    const step = 5

    if (key === 'w' || key === 'W') {
        let top = circle.style.top ? circle.style.top : 0
        circle.style.top = (parseInt(top) - step) + 'px'
    }else if (key === 'd' || key === 'D') {
        let left = circle.style.left ? circle.style.left : 0
        circle.style.left = (parseInt(left) + step) + 'px'
    }
    else if (key === 's' || key === 'S') {
        let top = circle.style.top ? circle.style.top : 0
        circle.style.top = (parseInt(top) + step) + 'px'
    }
    else if (key === 'a' || key === 'A') {
        let left = circle.style.left ? circle.style.left : 0
        circle.style.left = (parseInt(left) - step) + 'px'
    }

    const position = {
        top: circle.style.top,
        left: circle.style.left,
    }
    console.log(position)

    socket.send(JSON.stringify(position))
}
