import "./bootstrap";

const id = getID;
const wrapper = $("main");
const channel = Echo.private(`any-message-${id}`);

channel
    .subscribed(() => {})
    .listen(".AnyMessage", (ev) => {
        $(`[data-code="${ev.sender}"]`).detach();
        $(`.no-convo`).detach();
        wrapper.prepend(`<a data-code="${ev.sender}" href="convo/${ev.convo}">
        <div class="convo" style="border-left: 5px solid red;">
            <p class="online">${ev.sender}</p>
            <p>${ev.message}</p>
            <p>${ev.date}</p>
        </div>
    </a>`);
    });
let temp = false;
let justLeft = false;
Echo.join("user-connected")
    .here((data) => {
        let tempArray = [];
        data.forEach((e) => {
            tempArray.push(e.email);
        });
        setOnlineArray(tempArray);
    })
    .joining((data) => {
        justLeft == data.email ? clearTimeout(temp) : "";
        setOnlineArray([data.email]);
    })
    .leaving((data) => {
        justLeft = data.email;
        temp = setTimeout(() => {
            setOfflineArray([data.email]);
            justLeft = false;
        }, 5000);
    }).error(err=>console.log(err));

function setOnlineArray(values) {
    let convos = $(".convo-email");
    convos.each((i, e) => {
        if (values.includes(e.textContent)) {
            e.classList.remove("offline");
            e.classList.add("online");
        }
    });
}
function setOfflineArray(values) {
    let convos = $(".convo-email");
    convos.each((i, e) => {
        if (values.includes(e.textContent)) {
            e.classList.add("offline");
            e.classList.remove("online");
        }
    });
}