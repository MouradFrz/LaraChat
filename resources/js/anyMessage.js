import "./bootstrap";

const id = getID;

const wrapper = $("main");
const channel = Echo.private(`any-message-${id}`);

channel
    .subscribed(() => {})
    .listen(".AnyMessage", (ev) => {
        $(`[data-code="${ev.sender}"]`).detach()
        $(`.no-convo`).detach()
        wrapper.prepend(`<a data-code="${ev.sender}" href="convo/${ev.convo}">
        <div class="convo">
            <p style="font-weight:900" >${ev.sender}</p>
            <p>${ev.message}</p>
            <p>${ev.date}</p>
        </div>
    </a>`);
    });
console.log()
