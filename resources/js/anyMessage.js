import "./bootstrap";

const id = getID;

// const channel = Echo.private(`any-message-${id}`);

// channel.subscribed(() => {
//     console.log('listening');
// })
// .listen('.AnyMessage',(ev)=>{
//     console.log(ev)
// })

const channel = Echo.private(`any-message-${id}`);

channel.subscribed(() => {
})
.listen('.AnyMessage',(ev)=>{
    console.log(ev)
})
