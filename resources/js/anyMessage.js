import "./bootstrap";

const id = getID;

const wrapper = $("main");
const channel = Echo.private(`any-message-${id}`);


function refreshOnlineStatus(values){
    let convos = $('.convo-email')
    convos.each((i,e)=>{
        if(values.includes(e.textContent)){
            e.style.color='green'
        }else{
            e.style.color='#252525'
        }
    })
}

channel
    .subscribed(() => {})
    .listen(".AnyMessage", (ev) => {
        $(`[data-code="${ev.sender}"]`).detach();
        $(`.no-convo`).detach();
        wrapper.prepend(`<a data-code="${ev.sender}" href="convo/${ev.convo}">
        <div class="convo">
            <p style="font-weight:900" >${ev.sender}</p>
            <p>${ev.message}</p>
            <p>${ev.date}</p>
        </div>
    </a>`);
    });


Echo.join('user-connected')
.here(data=>{
    let tempArray = []
    data.forEach(e=>{
        tempArray.push(e.email)
    })
    refreshOnlineStatus(tempArray)
})
.joining(data=>{
    refreshOnlineStatus([data.email])
})
.leaving(data=>{
    refreshOnlineStatus([data])
})



